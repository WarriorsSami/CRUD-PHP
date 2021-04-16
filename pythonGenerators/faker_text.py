from faker import Faker
import random


Faker.seed(random.randint(1, 1000))
fake = Faker()
IT_list = ['Java', 'Python', 'Programming', 'React JS', 'Socket', 'Django',
           'C++', 'C#', 'Embedded Systems', 'Java Servlets', 'Java Applets',
           'AI Dev', 'Machine Learning', 'Functional Programming', 'Transfer Protocol',
           'Regex Editor', 'REST API', 'Login App', 'CRUD', 'GUI Swing', 'Bootstrap',
           'TailWindCss', 'JDBC', 'DB Manager', 'Flask Tech', 'Angular JS', 'JQUery',
           'Ajax', 'IDE', 'Game Engine', 'Chat Log', 'HTML Editor', 'Numpy', 'Faker Generator']

print(fake.sentence(nb_words=2, ext_word_list=IT_list))
