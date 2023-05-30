# -*- coding: utf-8 -*-
"""
Created on Mon Jul  5 14:17:18 2021

@author: pauli
"""

import json
import random
import urllib.request
import xmlrpc.client
import sys

config = json.loads(sys.argv[3])
#Clé API générée par Odoo
key = config["api_key"]
#Url : https://nomcompagnie.odoo.com  (début de l'url affichée quand on est connecté)
url = config["url"]
#Nom de la DB : nomcompagnie dans l'url
db = config["db"]
#Adresse mail utilisée pour créer le compte Odoo
username = config["username"]


class invoiceLine:
    def __initlg(self, name, quantity, price):
        self.name = name
        self.quantity = quantity
        self.price = price #prix à l'unité


#Fonction pour interagir avec Odoo (dispo dans leur doc : https://www.odoo.com/documentation/13.0/developer/howtos/backend.html#json-rpc-library)
def json_rpc(url, method, params):
    data = {
        "jsonrpc": "2.0",
        "method": method,
        "params": params,
        "id": random.randint(0, 1000000000),
    }
    req = urllib.request.Request(url=url, data=json.dumps(data).encode(), headers={
        "Content-Type":"application/json",
    })
    reply = json.loads(urllib.request.urlopen(req).read().decode('UTF-8'))
    if reply.get("error"):
        raise Exception(reply["error"])
    return reply["result"]

def call(url, service, method, *args):
    return json_rpc(url, "call", {"service": service, "method": method, "args": args})


#Fonction pour update la facture parce que le client a pas payé à temps et le prix a augmenté
def montantAugmente(url, db, uid, key, facture, invoice, taxe):
    supplement = (round(100 * facture["price"]) / 100) - invoice["amount_total"]
    linesInvoice = call(url, "object", "execute", db, uid, key, 'account.move.line', 'read', invoice["line_ids"])
    prixTotal = supplement
    prixTaxe = round(100 * prixTotal * taxe) / (100 + 100 * taxe)
    idInvoice = invoice["id"]

    argsLinesInvoice = [
    { #Première ligne : sert juste à équilibrer les comptes
            "account_internal_group" : "asset",
            "account_internal_type" : "receivable",
            "name":False,
            "quantity" : 1,
            "price_unit" : -prixTotal,
            "move_id" : idInvoice,
            "account_id" : 178, #400000 Trade debtors within one year - Customer
            "exclude_from_invoice_tab" : True,
            "reconciled" : True,
            "partner_id" : idClient,
    }]
    if taxe != 0:
        argsLinesInvoice.append({ #Prix lié à la taxe
                "account_internal_group" : "liability",
                "account_internal_type" : "other",
                "name":"21%",
                "quantity" : 1,
                "price_unit" : prixTaxe,
                "move_id" : idInvoice,
                "account_id" : 221,  #580001 Transfert de liquidités
                "exclude_from_invoice_tab" : True,
                "tax_base_amount" : prixTotal - prixTaxe,
                "tax_tag_ids" : [47],
                "tax_line_id" : 1,
                "tax_repartition_line_id" : 2,
                "tax_group_id" : 2,
                "partner_id" : idClient,
        })
    for i in lines: #Autres lignes
        argsLinesInvoice.append({
                "account_internal_group" : "income",
                "account_internal_type" : "other",
                "name" : "Frais de défaut de paiement",
                "quantity" : i.quantity,
                "price_unit" : prixTotal - prixTaxe,#i.price - taxe * i.price,
                "move_id" : idInvoice,
                "account_id" : 374, #700000 Sales rendered in Belgium (marchandises)
                "tax_ids" : [1], #1 pour 21%, 8 pour 0
                "tax_tag_ids" : [11],
                "partner_id" : idClient,
        })
    idLinesInvoice = call(url, "object", "execute", db, uid, key, 'account.move.line', 'create', argsLinesInvoice)
    return idLinesInvoice

#Fonction pour indiquer sur Odoo que le paiement a été fait
def ajoutPaiement(url, db, uid, key, facture, client, idClient, idInvoice, prixTotal):
    montant = prixTotal
    date = str(facture["validation_payment_date"]).split()[0]
    ref_paiement = str(client["id"]) + "_" + str(client["last_name"]) + str(client["first_name"]) + "_" + str(facture["number"]) + "_" + str(facture["created_at"]).split()[0]
    paiement = call(url, "object", "execute", db, uid, key, 'account.payment', 'search_read', [['ref', '=', ref_paiement]])
    if len(paiement) == 0:
        #On crée d'abord un paiement
        argsPaiement = {
                "amount" : montant,
                "partner_id" : idClient,
                "ref" : ref_paiement,
                "date" : date,
        }
        idPaiement = call(url, "object", "execute", db, uid, key, 'account.payment', 'create', argsPaiement)
        paiement = call(url, "object", "execute", db, uid, key, 'account.payment', 'write', [idPaiement], {"state" : "posted"})
    else:
        idPaiement = paiement[0]["id"]

    lineReleve = call(url, "object", "execute", db, uid, key, 'account.bank.statement.line', 'search_read', [["payment_ref", "=", ref_paiement]])
    if len(lineReleve) == 0:
        #On crée le relevé de compte associé
        argsReleve = {
                "date" : date,
                "journal_id" : 7,
        }
        idReleve = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'create', argsReleve)

        #On crée les lignes du relevé de compte
        argsLinesReleve = {
                "amount" : montant,
                "partner_id" : idClient,
                "payment_ref" : ref_paiement,
                "statement_id" : idReleve,
        }
        idLineReleve = call(url, "object", "execute", db, uid, key, 'account.bank.statement.line', 'create', argsLinesReleve)
        rel = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'read', [idReleve])
        idReleve = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'write', [idReleve], {"state" : "posted", "balance_end_real" : rel[0]["balance_end"]})
    else:
        rel = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'search_read', [["line_ids", "=", lineReleve[0]["id"]]])

    #On comptabilise la pièce comptable associée au relevé (sans ça on peut pas lettrer avec le paiement)
    move = call(url, "object", "execute", db, uid, key, 'account.move', 'search_read', [["line_ids", "=", rel[0]["move_line_ids"]]])
    idMove = call(url, "object", "execute", db, uid, key, 'account.move', 'write', [move[0]["id"]], {"state" : "posted", "ref" : ref_paiement})

    releve = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'search_read', [])
    #On remet le bon solde final pour le dernier relevé
    idReleve = call(url, "object", "execute", db, uid, key, 'account.bank.statement', 'write', [releve[0]["id"]], {"balance_end_real" : releve[0]["balance_end"]})

    #On réconcilie le paiement à la facture
    lineC = call(url, "object", "execute", db, uid, key, 'account.move.line', 'search_read', [["payment_id", "=", idPaiement], ["balance", "<", 0]])
    lineD = call(url, "object", "execute", db, uid, key, 'account.move.line', 'search_read', [["move_id", "=", idInvoice], ["balance", ">", 0]])
    recPart = call(url, "object", "execute", db, uid, key, 'account.partial.reconcile', 'search_read', [["credit_move_id", "=", lineC[0]["id"]], ["debit_move_id", "=", lineD[0]["id"]], ["amount", "=", montant]])
    if len(recPart) == 0:
        idRecPart = call(url, "object", "execute", db, uid, key, 'account.partial.reconcile', 'create', {"credit_move_id" : lineC[0]["id"], "debit_move_id" : lineD[0]["id"], "amount" : montant, "credit_amount_currency" : montant, "debit_amount_currency" : montant})




#Connexion à la database
common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url))
uid = common.authenticate(db, username, key, {})
url = url + "/jsonrpc"


#Récupération des données
null = ""
facture = json.loads(sys.argv[1]) #récup de la facture passée via la ligne de commande et conversion en json
client = json.loads(sys.argv[2]) #idem pour le client

#Odoo plante si on essaie de lui passer un none, on les remplace par un string vide
for i in client:
    if client[i] == None:
        client[i] = ""
    if isinstance(client[i], str) == True:
        client[i] = client[i].replace("&#39", "'")
for i in facture:
    if facture[i] == None:
        facture[i] = ""
    if isinstance(facture[i], str) == True:
        facture[i] = facture[i].replace("&#39", "'")
#Récup du nom du client selon les champs qui ont été remplis en bdd
if client["name"] == "":
    name = client["first_name"] + " " + client["last_name"]
else:
    name = client["name"]

clients = call(url, "object", "execute", db, uid, key, 'res.partner', 'search_read', [['name', '=', name], ['email', '=', client["email"]]])
invoice = call(url, "object", "execute", db, uid, key, 'res.partner', 'search_read', [['name', '=', facture["number"]]])
if len(clients) > 0:
    idClient = clients[0]["id"]
if len(invoice) > 0:
    idInvoice = facture[0]["id"]

taxe = 0.21
lines = [invoiceLine(facture["content"], 1, facture["price"])]
prixTotal = round(100 * facture["price"]) / 100
prixTaxe = round(100 * prixTotal * taxe) / (100 + 100 * taxe)
#On récupère la facture sur Odoo
invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'search_read', [['name', '=', facture["number"]]])[0]
#On voit si il y a des modifs à faire
if invoice["amount_total"] < facture["price"]:
    l = montantAugmente(url, db, uid, key, facture, invoice, taxe)
if invoice["payment_state"] != "paid" and facture["status"] in ["paid", "refunded"]:
    ajoutPaiement(url, db, uid, key, facture, client, idClient, invoice["id"], invoice["amount_residual"])
