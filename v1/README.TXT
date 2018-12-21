SJSU ID: 009729551
Name: QiQi Ou

After running everything from create.sql, you will need to manually create an admin account through the sign up page. 
This is because the sign up page and verify user page both check the hashed password, we cannot manually create a 
admin user via mysql terminal, because the password won't be hash (it won't go through php).
Please create the admin email with 'admin@gmail.com' and password 'admin' as the first user on the site.


