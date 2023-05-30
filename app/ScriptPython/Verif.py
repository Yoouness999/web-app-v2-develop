# -*- coding: utf-8 -*-
"""
Created on Mon Jul  5 10:11:06 2021

@author: pauli
"""

import json
import random
import urllib.request
import xmlrpc.client
import sys

config = json.loads(sys.argv[2])
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
    #if reply.get("error"):
    #raise Exception(reply["error"])
    return reply["result"]

def call(url, service, method, *args):
    return json_rpc(url, "call", {"service": service, "method": method, "args": args})

#Connexion à la database
common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url))
uid = common.authenticate(db, username, key, {})
url = url + "/jsonrpc"

#Récupération des données
null = ""

#facture = json.loads('{"id":6512,"number":"21\/W0176","title":"Monthly Subscription (01\/01\/2021 - 31\/01\/2021)","content":"Monthly Subscription (01\/01\/2021 - 31\/01\/2021)<br \/>3m\u00b3  (50)<br \/>Insurance Base  (0.00)<br \/>Storage duration > 12 mois -15% <br \/>","price":42.5,"user_id":"1330","item_id":null,"pickup_id":null,"fee_id":null,"status":"paid","attempt":0,"payment_date":"2021-01-01 09:06:32","validation_payment_date":"2021-01-01 14:06:32","payment_schedule":"2021-01-01","billing_ref":"monthly-2021-01-1330","billing_type":null,"billing_method":null,"billing_id":"","billing_exempted":0,"type":"invoiced","credit_note_id":null,"deleted_at":null,"last_attempt_at":null,"transferred_odoo":0,"created_at":"2021-01-01 14:06:32","updated_at":"2021-01-01 14:06:32"}')
facture = json.loads(sys.argv[1]) #récup de la facture passée via la ligne de commande et conversion en json
for i in facture:
    if isinstance(facture[i], str) == True:
        facture[i] = facture[i].replace("&#39", "'")

nomFacture = facture["number"]
taxe = 0.21
lines = [invoiceLine(facture["number"], 1, facture["price"])]
prixTotal = round(100 * sum([i.price * i.quantity for i in lines])) / 100
#prixTaxe = round(100 * prixTotal * taxe) / 121

#On regarde si la facture existe (grâce à son numéro, qui est unique) et si elle est bien comptabilisée
invoice = call(url, "object", "execute", db, uid, key, 'account.move', 'search_read', [['name', '=', nomFacture], ['state', '=', "posted"]])
if len(invoice) > 0:
    invoice_line = call(url, "object", "execute", db, uid, key, 'account.move.line', 'read', invoice[0]["invoice_line_ids"])
    #On vérifie si elle a été payée que ça a bien été pris en compte sur Odoo
    if facture["status"] in ["paid", "refunded"] and invoice[0]["amount_residual"] > 0:
        print("0")
    #On vérifie que toutes les lignes ont été ajoutées et que le montant est bien à jour
    elif invoice[0]["amount_total"] == prixTotal and len(invoice[0]["line_ids"]) > 1:
        print("1")
    else:
        print("0")
else:
    print("0")
