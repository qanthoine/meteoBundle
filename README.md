# MeteoBundle
Projet Parcours Symfony
#Présentation :
Bundle permettant à l'utilisateur de connaître la meteo actuelle via 3 methodes grâce à l'API d'<a href="http://openweathermap.org/">Openweathermap</a> :
<ul>
<li>Via une liste de villes pré-enregistrées</li>
<li>Via la saisie du nom de la ville</li>
<li>Via sa position GPS</li>
</ul>
Un cache permet de ne pas surcharger l'API.
#Version 2 :
Ajout des prévisions des 5 prochains jours.<br>
Transition des prévisions par "slider range" en JavaScript<br>
#Installation :
<li>Inscrivez-vous sur le site d'<a href="http://openweathermap.org/">Openweathermap</a></li>
<li>Récuperer votre ApiKey <a href="https://home.openweathermap.org/api_keys">ici</a></li>
<li>Installer le bundle dans votre dossier vendor de votre projet</li>
<li>Ajouter la ligne ci-dessous dans le ficher app/AppKernel.php</li>
<pre><code>new MeteoBundle\MeteoBundle(),</code></pre>
<li>Ajouter les lignes ci-dessous dans le ficher app/config/routing.yml</li>
<pre><code>meteo:
               resource: "@MeteoBundle/Resources/config/routing.yml"
               prefix:   /</code></pre>
<li>Ajouter les lignes ci-dessous en éditant avec vos données dans le ficher app/config/parameters.yml</li>
<pre><code>
    api_keys: 000000000000000000  # Votre ApiKeys
    units: metric # Unités de mesure (imperial pour Fahrenheit ou metric pour Celsius)
    langs: fr # Autre : en pour English, ru pour Russe, it pour Italien, ...)
    </code></pre>
<li>Entrez les commandes ci-dessous (Installation du CSS et des bases de données) :
<pre><code>php bin/console asset:install --symlink</code></pre>
<pre><code>php bin/console doctrine:schema:update --force</code></pre></li>
<li>Rendez-vous sur "/votreProjet/app_dev.php/meteo" et Profitez !</li>
