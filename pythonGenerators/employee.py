import mysql.connector
from texttable import Texttable
from faker import Faker
import random
import names
from datetime import date

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="userboard"
)

cursor = conn.cursor()

"""
cursor.execute("SELECT * FROM angajat")
result = cursor.fetchall()

table = Texttable()
table.set_cols_width([3, 8, 8, 20, 8, 8, 10, 8, 10, 8])
table.add_row(['ID', 'Last Name', 'First Name', 'Address', 'Manager', 'Team Leader',
               'Department ID', 'Team ID', 'Joining Date', 'Salary'])

for row in result:
    table.add_row(row)

print(table.draw())

conn.commit()
cursor.close()
conn.close()

fake = Faker()
query = "UPDATE angajat SET email=%(email)s WHERE id=%(id)s"

cursor.execute("SELECT * FROM angajat")
result = cursor.fetchall()

for row in result:
    data_employee = {
        'email': fake.email(),
        'id': row[0]
    }
    cursor.execute(query, data_employee)
    # print(row)

conn.commit()
cursor.close()
conn.close()
"""

"""
options = ["YES", "NO"]
query_insert = "INSERT INTO angajat (nume, prenume, adresa, email, manager, sef_proiect," \
               "departament_id, echipa_id, data_angajare, salariu) VALUES" \
               "(%(nume)s, %(prenume)s, %(adresa)s, %(email)s, %(manager)s, %(sef_proiect)s," \
               "%(departament_id)s, %(echipa_id)s, %(data_angajare)s, %(salariu)s)"
n = int(input())
fake = Faker()

for i in range(0, n):
    nume = names.get_last_name()
    prenume = names.get_first_name()
    adresa = fake.address()
    email = fake.email()

    departament_id = random.randint(1, 14)
    query_search = "SELECT * FROM departament WHERE id=%(dep_id)s"
    data_dep = {
        'dep_id': departament_id
    }
    cursor.execute(query_search, data_dep)
    result = cursor.fetchone()
    while result is None:
        departament_id = random.randint(1, 14)
        query_search = "SELECT * FROM departament WHERE id=%(dep_id)s"
        data_dep = {
            'dep_id': departament_id
        }
        cursor.execute(query_search, data_dep)
        result = cursor.fetchone()

    echipa_id = random.randint(1, 7)
    query_search = "SELECT * FROM echipa WHERE id=%(team_id)s"
    data_team = {
        'team_id': echipa_id
    }
    cursor.execute(query_search, data_team)
    result = cursor.fetchone()
    while result is None:
        echipa_id = random.randint(1, 7)
        query_search = "SELECT * FROM echipa WHERE id=%(team_id)s"
        data_team = {
            'team_id': echipa_id
        }
        cursor.execute(query_search, data_team)
        result = cursor.fetchone()

    is_manager = random.randint(0, 1)
    is_leader = random.randint(0, 1)

    if is_manager == 0:
        query_select = "SELECT * FROM angajat WHERE departament_id=%(dep_id)s AND manager=%(manager)s"
        data_manager = {
            'dep_id': departament_id,
            'manager': options[is_manager]
        }
        cursor.execute(query_select, data_manager)
        result = cursor.fetchone()
        if result is not None:
            is_manager = 1

    if is_leader == 0:
        query_select = "SELECT * FROM angajat WHERE echipa_id=%(team_id)s AND sef_proiect=%(leader)s"
        data_leader = {
            'team_id': echipa_id,
            'leader': options[is_leader]
        }
        cursor.execute(query_select, data_leader)
        result = cursor.fetchone()
        if result is not None:
            is_leader = 1

    salariu = str(random.randint(1000, 10000)) + ".00"
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
    # data = str(year) + "-" + str(month) + "-" + str(day)
    # print(data)

    data_employee = {
        'nume': nume,
        'prenume': prenume,
        'adresa': adresa,
        'email': email,
        'manager': options[is_manager],
        'sef_proiect': options[is_leader],
        'departament_id': departament_id,
        'echipa_id': echipa_id,
        'data_angajare': data,
        'salariu': salariu
    }
    # print(data_employee)
    cursor.execute(query_insert, data_employee)

print(str(n) + " employees inserted successfully!")

conn.commit()
cursor.close()
conn.close()
"""

Faker.seed(random.randint(1, 1000))
fake = Faker()
query = "UPDATE angajat SET adresa=%(adr)s WHERE id=%(id)s"

cursor.execute("SELECT * FROM angajat")
result = cursor.fetchall()

for row in result:
    data_angajat = {
        'adr': fake.address() + ", " + fake.city () + ", " + fake.country(),
        'id': row[0]
    }
    cursor.execute(query, data_angajat)

conn.commit()
cursor.close()
conn.close()
