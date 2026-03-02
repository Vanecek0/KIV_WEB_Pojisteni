<h1>Seminární práce KIV/WEB</h1>
<p>Seminární práce pro kurz KIV/WEB. Cílem bylo vytvořit webovou stránku obsahující základní CRUD operace, CSS (Bootstrap), JS (JQuery), MySQL databáze. Další popis v readme.docx</p>
<h2>Funkce</h2>
<ul>
    <li>Procházení nabídek pojištění</li>
	<li>Přihlášení do portálu pojištění</li>
	<li>Vytváření nových smluv, pojistných událostí, uživatelů</li>
</ul>

<h2>Použité technologie</h2>
<ul>
	<li><a href="https://twig.symfony.com/">Twig</a></li>
    <li><a href="https://getbootstrap.com/">Bootstrap</a></li>
	<li><a href="https://jquery.com/">JQuery</a></li>
</ul>

<h2>Doporučené požadavky</h2>
<ul>
	<li><strong>Node.js</strong> verze 25</li>
   <li><strong>npm</strong> verze 11.7 </br>Ověření verze: <code>npm -v</code></li>
   <li><strong>composer</strong> verze 2.8.X </br>Ověření verze: <code>composer --version</code></li>
   <li><strong>php</strong> verze 8.4.X </br>Ověření verze: <code>php --version</code></li>
   <li><strong>apache</strong> verze 2.4</li>
   <li><strong>MariaDB</strong> verze 10.4.XX</li>
   <li><strong>Git</strong> verze 2.5 </br>Ověření verze: <code>git --version</code></li>
</ul>

<h2>Doporučené prostředí</h2>
<ul> 
   <li>Operační systém: Windows 10/11, macOS, nebo Linux</li> 
   <li>XAMPP, WAMP nebo jiný web server</li>
   <li>Databáze: MariaDB, phpMyAdmin</li>
   <li>Stabilní připojení k internetu (pro stažení balíčků)</li> 
</ul>

<h2>Konfigurace webového serveru</h2>
<p>Pro správné fungování je nutné nastavit root přímo do složky projektu (tam, kde je umístěn .htaccess). URL adresa by měla vypadat např takto: http://localhost/, http://localhost/portal, ...</p>
<p>Login údaje k databázi, vč. tabulky, se nachází v app/Core/Database.php</p>

<h2>Import databáze pomocí phpMyAdmin</h2>
<ul> 
   <li>Pomocí phpMyAdmin vytvořte novou prázdnou tabulku "carinsurance"</li> 
   <li>Z horní nabídce zvolte "import" a vložte soubor <code>carinsurance.sql</code> v rootu projektu</li>
   <li>Hotovo</li>
</ul>

<h2>Instalace</h2>
<ol>
	<li>Stáhněte nebo naklonujte repozitář.</li>
    <li>V terminálu spusťte příkaz <code>composer install</code> pro instalaci závislostí.</li>
	<li>V terminálu spusťte příkaz <code>npm ci</code> pro instalaci závislostí.</li>
	<li>Spuste Apache a MySQL ve webovém serveru (např. XAMPP, WAMP)</li>
	<li>Otevřete adresu serveru, např. <a href="http://localhost:8000">http://localhost:8000</a> v prohlížeči.</li>
</ol>
