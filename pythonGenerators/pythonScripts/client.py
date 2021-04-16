import mysql.connector
import names
from faker import Faker
import random


conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="userboard"
)

cursor = conn.cursor()

"""
sql.execute("CREATE DATABASE IF NOT EXISTS DB")
sql.execute("USE DB")
sql.execute("CREATE TABLE IF NOT EXISTS tb (id INT UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY, nume VARCHAR(10))")
add_client = ("INSERT INTO tb (nume) VALUES (%(nume)s)")
data_client = {
    'nume': 'Sami Barbut-Dica'
}
sql.execute(add_client, data_client)


fake = Faker()
n = int(input())
query = "INSERT INTO client (prenume, nume, adresa) VALUES (%(prenume)s, %(nume)s, %(adresa)s)"

for i in range(0, n):
    data_client = {
        'prenume': names.get_first_name(),
        'nume': names.get_last_name(),
        'adresa': fake.address()
    }
    cursor.execute(query, data_client)
    print(query)

conn.commit()
cursor.close()
conn.close()

print(str(n) + " clients inserted successfully!")
"""

Faker.seed(random.randint(1, 1000))
fake = Faker()
query = "UPDATE client SET adresa=%(adr)s WHERE client_id=%(id)s"

cursor.execute("SELECT * FROM client")
result = cursor.fetchall()

for row in result:
    data_client = {
        'adr': fake.address() + ", " + fake.city () + ", " + fake.country(),
        'id': row[0]
    }
    cursor.execute(query, data_client)

conn.commit()
cursor.close()
conn.close()
# """
