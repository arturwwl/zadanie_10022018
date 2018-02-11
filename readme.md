<h1>Instrukcja</h1>

<ol>
<li>Pobrać pliki
</li>
<li>Pobrać pakiety
<code>composer install</code>
</li>
<li>w pliku .env ustawić danę do bazy np.
<code>DATABASE_URL=mysql://www:www@127.0.0.1:/zadanie_10022018</code>
</li>
<li>
Włączenie serwera
<p><code>php -S 127.0.0.1:8000 -t public</code></p>
</li>
<li>Import db
<p><code>php bin/console doctrine:migrations:diff
   
   php bin/console doctrine:migrations:migrate</code></p>
</li>
<li>Import map miast
<p> w pliku stc/Controller/WelcomeController.php zmienić dostępność metody generateMapAction() i przejść pod wskazany wyżej url
</li>
</ol>