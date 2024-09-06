Technical choices 
---

This project use SQLite for quicker install and demo. Demo Data are located in `/var/data.db` and are committed to the git repo for the purpose of an easy install.

This project use EasyAdminbundle to accelerate full management of simple CRUD entities. 

Installation guide
--

Install app dependencies : `composer install`

Configure your SMTP and email parameters in the `.env.local` (Optional)

Run the local built in http server : `symfony server:start`

The app should be running at `http://localhost:8000/`

Admin is located at `http://localhost:8000/admin` login is `demo:demo`

For weekly stats run a worker with `php bin/console messenger:consume scheduler_default` alternatively you can run a cronjob than run the command `php bin/console app:weekly-stats`

----

If you want a fresh database you can just generate fixtures `php bin/console doctrine:fixtures:load`

