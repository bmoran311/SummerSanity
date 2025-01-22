# Summer Sanity

Admin template is based upon tailadmin -> https://tailadmin.com
If we really likes it -  there's a pro version (should be like 35/40 bucks)

If we like this we should delete the /images folder content - as it's just testing/dummy files...

Local Install - 

Should simply be:
1) Checkout the Repo
2) npm install && npm run dev (this will install dependencies and spin up the dev server for css compiling)
3) composer install
4) update the .env file to you local mysql database
5) php atisan migrate
6) php artisan db:seed
7) php artisan serve

Documentation for sortable tables is here: 
https://github.com/tofsjonas/sortable
If you want a column to not be sortable - give the th a 'no-sort' class

Documentation for Quill Editor is here:
https://quilljs.com/docs/quickstart
