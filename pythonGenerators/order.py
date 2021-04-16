import mysql.connector
import random


conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="userboard"
)

cursor = conn.cursor()

query_insert = "INSERT INTO comanda (data_finalizare, client_id, produs_id, echipa_id)" \
               "VALUES (%(data_fin)s, %(cl_id)s, %(pr_id)s, %(tm_id)s)"
n = int(input())

for i in range(0, n):
    year = random.randint(2009, 2020)
    data = str(year)
    month = random.randint(1, 12)
    if month < 10:
        data += "-0" + str(month)
    else:
        data += "-" + str(month)
    day = random.randint(1, 28)
    if day < 10:
        data += "-0" + str(day)
    else:
        data += "-" + str(day)

    client = random.randint(1, 2000)
    query_search = "SELECT * FROM client WHERE client_id=%(sc_id)s LIMIT 1"
    data_client = {
        'sc_id': client
    }
    cursor.execute(query_search, data_client)
    result = cursor.fetchone()
    while result is None:
        client = random.randint(1, 2000)
        data_client = {
            'sc_id': client
        }
        cursor.execute(query_search, data_client)
        result = cursor.fetchone()

    product = random.randint(1, 100)
    query_search = "SELECT * FROM produs WHERE id=%(sp_id)s AND disponibil=\"YES\""
    data_produs = {
        'sp_id': product
    }
    cursor.execute(query_search, data_produs)
    result = cursor.fetchone()
    while result is None:
        product = random.randint(1, 100)
        data_produs = {
            'sp_id': product
        }
        cursor.execute(query_search, data_produs)
        result = cursor.fetchone()

    team = random.randint(1, 100)
    query_search = "SELECT * FROM echipa WHERE id=%(st_id)s AND " \
                   "id NOT IN (SELECT echipa_id FROM proiect WHERE finalizat=\"WORKING\")"
    data_team = {
        'st_id': team
    }
    cursor.execute(query_search, data_team)
    result = cursor.fetchone()
    while result is None:
        team = random.randint(1, 100)
        data_team = {
            'st_id': team
        }
        cursor.execute(query_search, data_team)
        result = cursor.fetchone()

    data_order = {
        'data_fin': data,
        'cl_id': client,
        'pr_id': product,
        'tm_id': team
    }
    cursor.execute(query_insert, data_order)
    # print(str(data) + " " + str(client) + " " + str(product) + " " + str(team))

print(str(n) + " orders inserted successfully!")

conn.commit()
cursor.close()
conn.close()
