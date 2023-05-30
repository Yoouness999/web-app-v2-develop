# -*- coding: utf-8 -*-
"""
Created on Thu Jul  1 10:28:22 2021

@author: pauli
"""

import json
import random
import urllib.request
import xmlrpc.client
import sys
import datetime

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


#Fonctions pour interagir avec Odoo
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





#Fonction pour ajouter un client si nécessaire
def ajoutClient(url, db, uid, key, client, name):
    #On ajoute le client
    args = {
            #"citizen_identification" : "ident",
            "city" : client["city"],
            "company_type" : "person", #ou company
            #"country_id" : 113,
            "customer_rank" : 1,
            "email" : client["email"],
            #"function" : "Poste contact",
            #"lang" : "fr_BE",
            "name" : name,
            "phone" : client["phone"],
            #"state_id" : 203,
            "street" : client["street"] + " " + client["number"] + client["box"],
            #"title" : 3, #Monsieur
            "type" : "contact",
            "tz" : "Europe/Brussels",
            "vat" : client["billing_vat"],
            #"website" : "adresseweb.be",
            "zip" : client["postalcode"]
    }
    if client["business"] == 1:
        args["company_type"] = "company"
        args["vat"] = client["company_vat_number"]
    if args["vat"] == "NOVAT":
        args["vat"] = ""
    idClient = call(url, "object", "execute", db, uid, key, 'res.partner', 'create', args)

    #Son adresse de facturation si elle a été remplie en bdd
    if client["billing_city"] != "" or client["billing_street"] != "":
        args = {
               "city" : client["billing_city"],
               "name" : name,
               "parent_id" : idClient,
               "street" : client["billing_street"] + " " + client["billing_number"] + client["billing_box"],
               "type" : "invoice",
               "zip" : client["billing_postalcode"],
        }
        idc = call(url, "object", "execute", db, uid, key, 'res.partner', 'create', args)

    #Si c'est une entreprise, il y a une troisième adresse à rajouter
    if client["business"] == 1 and (client["company_address_locality"] != "" or client["company_address_route"] != ""):
        args = {
           "city" : client["company_address_locality"],
           "name" : name,
           "parent_id" : idClient,
           "street" : client["company_address_route"] + " " + client["company_address_street_number"] + client["company_address_box"],
           "type" : "other",
           "zip" : client["company_address_postal_code"]
        }
        idc = call(url, "object", "execute", db, uid, key, 'res.partner', 'create', args)

    #Son compte bancaire
    args = {
            "acc_number" : client["billing_iban"],
            "acc_type" : "bank",
            "partner_id" : idClient
    }
    idb = call(url, "object", "execute", db, uid, key, 'res.partner.bank', 'create', args)
    return idClient

def ajoutFacture(url, db, uid, key, facture, idClient, ref_paiement):
    argsInvoice = {
            "name" : facture["number"],
            "state" : "draft",
            "journal_id" : 1,
            "move_type" : "out_invoice",
            "invoice_date" : facture["created_at"],
            "partner_id" : idClient,
            "payment_reference" : ref_paiement,
    }
    return call(url, "object", "execute", db, uid, key, 'account.move', 'create', argsInvoice)

def ajoutLignesFacture(url, db, uid, key, facture, lignesFacture, idInvoice, idClient, prixTotal, prixTaxe):
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
    for i in lignesFacture: #Autres lignes
        argsLinesInvoice.append({
                "account_internal_group" : "income",
                "account_internal_type" : "other",
                "name" : i.name,
                "quantity" : i.quantity,
                "price_unit" : prixTotal - prixTaxe,#i.price - taxe * i.price,
                "move_id" : idInvoice,
                "account_id" : 374, #700000 Sales rendered in Belgium (marchandises)
                "tax_ids" : [1], #1 pour 21%, 8 pour 0
                "tax_tag_ids" : [11],
                "partner_id" : idClient,
        })
    idLinesInvoice = call(url, "object", "execute", db, uid, key, 'account.move.line', 'create', argsLinesInvoice)
    invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'write', [idInvoice], {"state" : "posted", "posted_before" : True, "fiscal_position_id" : 2})
    return idLinesInvoice


#Fonction pour ajouter un paiement si nécessaire
def ajoutPaiement(url, db, uid, key, facture, client, idClient, idInvoice, prixTotal, ref_paiement):
    montant = prixTotal
    date = str(facture["validation_payment_date"]).split()[0]
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
common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url.strip()))
uid = common.authenticate(db, username, key, {})
url = url + "/jsonrpc"


#Récupération des données
null = ""
"""
facture = json.loads('{"id":6512,"number":"21\/W0176 test","title":"Monthly Subscription (01\/01\/2021 - 31\/01\/2021)","content":"Monthly Subscription (01\/01\/2021 - 31\/01\/2021)<br \/>3m\u00b3  (50)<br \/>Insurance Base  (0.00)<br \/>Storage duration > 12 mois -15% <br \/>","price":42.5,"user_id":"1330","item_id":null,"pickup_id":null,"fee_id":null,"status":"paid","attempt":0,"payment_date":"2021-01-01 09:06:32","validation_payment_date":"2021-01-01 14:06:32","payment_schedule":"2021-01-01","billing_ref":"monthly-2021-01-1330","billing_type":null,"billing_method":null,"billing_id":"","billing_exempted":0,"type":"invoiced","credit_note_id":null,"deleted_at":null,"last_attempt_at":null,"transferred_odoo":0,"created_at":"2021-01-01 14:06:32","updated_at":"2021-01-01 14:06:32"}')
client = json.loads('{"id":1330,"email":"julien.vannier-moreau@orange.fr","name":"Julien Vannier-moreau 2","first_name":"Julien","last_name":"Vannier-moreau","postalcode":"3010","add_infos":null,"city":"Leuven","box":null,"number":"14","street":"Patrijzenlaan","latitude":null,"longitude":null,"phone":"+32 479215764","oauth_id":"","godfather_id":"","lang":"en","business":0,"billing_card_year":"","billing_card_month":"","billing_card_number":"","billing_card_holder":"","billing_card_id":"","billing_wallet_id":"","billing_info_type":null,"billing_status":"paid","billing_type":"adyen","billing_env":"production","billing_id":null,"billing_customer_id":null,"billing_next_date":null,"billing_city":"Leuven","billing_postalcode":"3010","billing_box":null,"billing_number":"14","billing_street":"Patrijzenlaan","billing_to":"Julien Vannier-moreau","billing_vat":null,"billing_exempted":0,"billing_address":"Patrijzenlaan","password":"$2y$10$n2TioRG.LQoSIqTynjKBQesOgXBq4quBB6\/emZ8by1EyOINoVvLP.","activation_code":"CvETeVH5J9bxOmDnYj0kjhda40FpbNdmmuw4Pp9fgxBqepmS7SF21HQTVm0u61ba667caed6ec95212a5a0d75b4ce7d","active":1,"remember_token":null,"status":"active","invitation_code":"MTMzMA==","billing_method":"sepa","avg_cart":"","last_order":"2020-10-18 19:02:03","country":"BE","customer_type":"private","id_card_file_recto":null,"id_card_file_verso":null,"billing_deposit":"0.00","address_country":null,"company_name":null,"company_vat_number":null,"company_address_route":null,"company_address_street_number":null,"company_address_locality":null,"company_address_postal_code":null,"company_address_country":"BE","company_address_box":null,"order_plan_id":2,"order_plan_region_id":135,"order_plan_price_per_month":"50","order_assurance_id":1,"order_insurance_custom_price":null,"order_storing_duration_id":4,"end_subscription":null,"photo":null,"is_billable":null,"billing_iban":"BE87 3631 7922 2694","billing_iban_owner":"Julien Vannier-Moreau","advisor_id":null,"billing_country":"1","agree":1,"agree_date":"2020-10-18 19:02:03","created_at":"2020-10-18 23:01:40","updated_at":"2020-10-27 11:54:46","deleted_at":null,"end_commitment_period":"2021-10-26 14:00:00"}')
"""

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

#Conversion des balises HTML <br> et <p> en retours à la ligne
facture["content"] = facture["content"].replace("<br />", "\n")
facture["content"] = facture["content"].replace("<br/>", "\n")
facture["content"] = facture["content"].replace("<br >", "\n")
facture["content"] = facture["content"].replace("<br>", "\n")
facture["content"] = facture["content"].replace("<p>", "")
facture["content"] = facture["content"].replace("</p>", "\n")

#Récup du nom du client selon les champs qui ont été remplis en bdd
if client["name"] == "":
    name = client["first_name"] + " " + client["last_name"]
else:
    name = client["name"]

#Référence de paiement
ref_paiement = str(client["id"]) + "_" + str(client["last_name"]) + str(client["first_name"]) + "_" + str(facture["number"]) + "_" + str(facture["created_at"]).split()[0]


client = {
        "city" : client["city"],
        "email" : client["email"],
        "business" : client["business"],
        "phone" : client["phone"],
        "street" : client["street"],
        "number" : client["number"],
        "box" : client["box"],
        "billing_vat" : client["billing_vat"],
        "postalcode" : client["postalcode"],
        "company_vat_number" : client["company_vat_number"],
        "billing_city" : client["billing_city"],
        "billing_street" : client["billing_street"],
        "billing_number" : client["billing_number"],
        "billing_box" : client["billing_box"],
        "billing_postalcode" : client["billing_postalcode"],
        "company_address_locality" : client["company_address_locality"],
        "company_address_route" : client["company_address_route"],
        "company_address_street_number" : client["company_address_street_number"],
        "company_address_box" : client["company_address_box"],
        "company_address_postal_code" : client["company_address_postal_code"],
        "billing_iban" : client["billing_iban"],
        "name" : name
}
"""
facture = {
        "number" : facture["number"],
        "created_at" : facture["created_at"],
}
"""
lignesFacture = [invoiceLine(facture["content"], 1, facture["price"])]



#On vérifie si le client est déjà enregistré sur Odoo et si pas on le rajoute
clients = call(url, "object", "execute", db, uid, key, 'res.partner', 'search_read', [['name', '=', client["name"]], ['email', '=', client["email"]]])
if len(clients) > 0:
    idClient = clients[0]["id"]
else:
    idClient = ajoutClient(url, db, uid, key, client, client["name"])

taxe = 0.21
prixTotal = round(100 * facture["price"]) / 100 #sum([i.price * i.quantity for i in lines]) * (1+taxe)
prixTaxe = round(100 * prixTotal * taxe) / (100 + 100 * taxe)

#Il y a de temps en temps une facture sans numéro dans la bdd
if len(facture["number"]) > 0:
    #On vérifie toujours d'abord si l'ajout a pas déjà été partiellement fait (au cas où le script aurait planté en cours de route la veille)
    invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'search_read', [["name", "=", facture["number"]]])
    if len(invoice) == 0:
        #On crée d'abord une facture sans lignes
        idInvoice = ajoutFacture(url, db, uid, key, facture, idClient, ref_paiement)
    else:
        idInvoice = invoice[0]["id"]

    if len(invoice) > 0 and len(invoice[0]["line_ids"]) > 0:
        idLinesInvoice = invoice[0]["line_ids"]
        invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'write', [idInvoice], {"state" : "posted", "posted_before" : True, "fiscal_position_id" : 2})
    else:
        #Ajout des lignes
        idLinesInvoice = ajoutLignesFacture(url, db, uid, key, facture, lignesFacture, idInvoice, idClient, prixTotal, prixTaxe)

    #Si la facture a déjà été payée, on l'ajoute sur Odoo
    #On vérifie aussi d'abord si le montant correspond parce que parfois le système plante et il y a deux factures avec le même numéro en bdd et c'est à cette étape que ça fait planter le transfert
    invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'read', [idInvoice])[0]
    if facture["status"] == "paid" and prixTotal == invoice["amount_total"]:
        ajoutPaiement(url, db, uid, key, facture, client, idClient, idInvoice, prixTotal, ref_paiement)
