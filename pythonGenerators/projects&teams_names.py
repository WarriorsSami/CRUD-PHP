import mysql.connector
from faker import Faker
import random


conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="userboard"
)

cursor = conn.cursor()
Faker.seed(random.randint(1, 1000))
fake = Faker()
IT_list = ['Java', 'Python', 'Programming', 'React JS', 'Socket', 'Django',
           'C++', 'C#', 'Embedded Systems', 'Java Servlets', 'Java Applets',
           'AI Dev', 'Machine Learning', 'Functional Programming', 'Transfer Protocol',
           'Regex Editor', 'REST API', 'Login App', 'CRUD', 'GUI Swing', 'Bootstrap',
           'TailWindCss', 'JDBC', 'DB Manager', 'Flask Tech', 'Angular JS', 'JQUery',
           'Ajax', 'IDE', 'Game Engine', 'Chat Log', 'HTML Editor', 'Numpy', 'Faker Generator']

"""
query_insert = "INSERT INTO echipa (denumire) VALUES (%(name)s)"
n = int(input())

for i in range(0, n):
    data_team = {
        'name': fake.company()
    }
    cursor.execute(query_insert, data_team)

print(str(n) + " teams inserted successfully!")
"""

"""
query_insert = "INSERT INTO proiect (tip, deadline, echipa_id, finalizat) " \
               "VALUES (%(tip)s, %(data)s, %(team)s, %(state)s)"
options = ["WORKING", "DONE"]
n = int(input())

for i in range(0, n):
    state = random.randint(0, 1)
    team = random.randint(1, 100)
    query_select = "SELECT * FROM echipa WHERE id=%(team_id)s LIMIT 1"
    if state == 0:
        query_select = "SELECT * FROM echipa WHERE id=%(team_id)s AND id NOT IN" \
                       "(SELECT echipa_id FROM proiect WHERE finalizat=\"WORKING\") LIMIT 1"

    data_team = {
        'team_id': team
    }
    cursor.execute(query_select, data_team)
    result = cursor.fetchone()
    while result is None:
        team = random.randint(1, 100)
        data_team = {
            'team_id': team
        }
        cursor.execute(query_select, data_team)
        result = cursor.fetchone()

    data_project = {
        'tip': fake.sentence(nb_words=2, ext_word_list=IT_list),
        'data': fake.date_this_decade(),
        'team': team,
        'state': options[state]
    }
    cursor.execute(query_insert, data_project)
    # print(data_project)

print(str(n) + " projects inserted successfully!")
"""

query_update = "UPDATE proiect SET tip=%(tip)s, deadline=%(data)s WHERE id=%(id)s"
query_select = "SELECT * FROM proiect"

cursor.execute(query_select)
result = cursor.fetchall()

for row in result:
    data_proiect = {
        'tip': row[4][:-1],
        'data': fake.date_this_decade(),
        'id': row[0]
    }
    cursor.execute(query_update, data_proiect)

conn.commit()
cursor.close()
conn.close()
