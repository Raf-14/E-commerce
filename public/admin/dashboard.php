<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vue d'ensemble des ventes</title>
  <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
  <header>
    <h1>Vue d'ensemble des ventes</h1>
    <div class="filters">
      <label for="date-filter">Filtrer par date:</label>
      <input type="date" id="date-filter">
      <label for="product-filter">Filtrer par produit:</label>
      <input type="text" id="product-filter">
    </div>
  </header>
  <main>
    <section class="charts">
      <div id="daily-sales-chart"></div>
      <div id="weekly-sales-chart"></div>
      <div id="monthly-sales-chart"></div>
    </section>
    <section class="top-products">
      <h2>Top 5 des produits les plus vendus</h2>
      <ul>
        <li>Produit 1 - 100 unités - $500</li>
        <li>Produit 2 - 80 unités - $400</li>
        <li>Produit 3 - 60 unités - $300</li>
        <li>Produit 4 - 50 unités - $250</li>
        <li>Produit 5 - 40 unités - $200</li>
      </ul>
    </section>
    <section class="summary">
      <h2>Résumé des ventes</h2>
      <p>Total des ventes: $2000</p>
      <p>Nombre de commandes: 50</p>
      <p>Marge bénéficiaire: $1000</p>
    </section>
  </main>
</body>
</html>
