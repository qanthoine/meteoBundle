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
#Installation :
<li>Inscrivez-vous sur le site d'<a href="http://openweathermap.org/">Openweathermap</a></li>
<li>Récuperer votre ApiKey <a href="https://home.openweathermap.org/api_keys">ici</a></li>
<li>Installer le bundle dans votre dossier vendor de votre projet</li>
<li>Ajouter le bundle dans le kernel (app/AppKernel.php)
<pre><code>new MeteoBundle\MeteoBundle()</code></pre>
<li>Entrez les commandes ci-dessous (Installation du CSS et des bases de données) :
<pre><code>php bin/console asset:install --symlink</code></pre>
<pre><code>php bin/console doctrine:schema:update --force</code></pre></li>
<li>Ouvrez "MeteoBundle/Controller/MeteoController" et editez les lignes (18, 55, 80) par votre ApiKey</li>
<li>Rendez-vous sur "/votreProjet/app_dev.php/meteo" et Profitez !</li>
