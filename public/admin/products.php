<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        const dropdown = document.querySelector('.dropdown');
        dropdown.addEventListener('click', () => {
            const menu = document.querySelector('.menu');
            menu.classList.toggle('show');
        });
    </script>
</head>
<body>
    <aside>
        <h2>Name of Shop</h2>
        <ul>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="#"><i class="fas fa-box-open"></i> Products</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Clients</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Statistiques</a></li>
            <li><a href="#"><i class="fas fa-headset"></i> Support client</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>
    <!-- Main content -->
     <main>
        <section class="first-section">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <div class="profile">
                <img src="../assets/images/user1.jpeg" alt="Profile picture">
                <h3>John Doe</h3>
            </div>
        </section>
        <section class="second-section">
            <div class="barre-container">
                <div class="barre barre-1">
                    <select name="barre" id="barre">
                        <option value="all">Category</option>
                        <option value="fruits">Fruits</option>
                        <option value="legumes">Legumes</option>
                        <option value="produit_frais">Produit frais</option>
                    </select>
                </div>
                <div class="barre barre-2">
                    <select name="status" id="status">
                        <option value="all">Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="barre barre-3">
                    <select name="price" id="price">
                        <option value="all">Price</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>       
            </div>

            <div class="add-product-btn">
                <button onclick="openModal('add-product-modal')"><i class="fas fa-plus">Ajouter un produit</i></button>
            </div>
            
        </section>
       <!-- Modal for adding a product -->
            <section class="section-modal" id="add-product-modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                <h3>Ajouter un produit</h3>
                <button type="button" class="close" onclick="closeModal('add-product-modal')">&times;</button>
                </div>
                <div class="modal-body">
                <div class="add-product">
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Nom du produit" required>
                    <input type="text" name="price" placeholder="Prix" required>
                    <input type="number" name="stock" placeholder="Stock" required>
                    <select name="category" id="category" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="fruit">Fruit</option>
                        <option value="legume">Légume</option>
                        <option value="produit_frais">Produit frais</option>
                    </select>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <input type="file" name="image" accept="image/*" required>
                    <button type="submit">Ajouter le produit</button>
                    </form>
                </div>
                </div>
            </div>
            </section>

            <!-- Modal for updating a product -->
            <section class="section-modal" id="update-product-modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                <h3>Mettre à jour un produit</h3>
                <button type="button" class="close" onclick="closeModal('update-product-modal')">&times;</button>
                </div>
                <div class="modal-body">
                <div class="update-product">
                    <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="name" value="update" required>
                    <input type="text" name="price" value="update" required>
                    <input type="number" name="stock" value="update" required>
                    <select name="category" id="category" required>
                        <option value="fruit">Fruit</option>
                        <option value="legume">Légume</option>
                        <option value="produit_frais">Produit frais</option>
                    </select>
                    <textarea name="description" value="update" required></textarea>
                    <input type="file" name="image" accept="image/*">
                    <button type="submit">Mettre à jour le produit</button>
                    </form>
                </div>
                </div>
            </div>
            </section>

        <section class="third-section">
            <div class="product-list">
            <h2>Liste des Produits</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom du Produit</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Vendus</th>
                            <th>Revenu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <!-- Product rows will be dynamically added here -->
                    </tbody>
                </table>
                <div class="pagination">
                    <button id="prevPage" disabled> <i class="fas fa-angle-double-left"></i></button>
                    <span id="pageNumber">1</span>
                    <button id="nextPage"><i class="fas fa-angle-double-right"></i></button>
                </div>        
            </div>
     </main>
     <script>
        const products = [
            { name: "Navy Blue Smart Watch", category: "Men, Watch", price: "$230", stock: 500, sold: 65, revenue: "$14,950" },
            { name: "Blue Grey Backpack", category: "Men, Backpack", price: "$150", stock: 380, sold: 74, revenue: "$11,100" },
            { name: "Navy Blue Sneaker Shoe", category: "Men, Shoe", price: "$175", stock: 160, sold: 86, revenue: "$15,050" },
            { name: "Fashion Ladies Bag", category: "Women, Bag", price: "$210", stock: 275, sold: 63, revenue: "$13,230" },
            { name: "Brown Leather Bracelet", category: "Men, Bracelet", price: "$165", stock: 450, sold: 48, revenue: "$10,560" },
            { name: "Fancy Ladies Leather Bag", category: "Women, Bag", price: "$310", stock: 325, sold: 36, revenue: "$12,600" },
            { name: "Brown Leather Watch", category: "Men, Watch", price: "$472", stock: 250, sold: 90, revenue: "$29,264" },
            { name: "Men’s Leather Wallet", category: "Men, Wallet", price: "$399", stock: 320, sold: 59, revenue: "$23,541" },
            { name: "Blue Fashion Backpack", category: "Men, Backpack", price: "$525", stock: 260, sold: 34, revenue: "$18,200" },
            { name: "Plain Blue Cap", category: "Men, Cap", price: "$620", stock: 475, sold: 28, revenue: "$17,360" }
        ];

        let currentPage = 1;
        const itemsPerPage = 5;

        function displayProducts() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const displayedProducts = products.slice(startIndex, endIndex);
            const tableBody = document.getElementById("productTableBody");
            tableBody.innerHTML = "";
            displayedProducts.forEach(product => {
                const row = `<tr>
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>${product.price}</td>
                    <td>${product.stock}</td>
                    <td>${product.sold}</td>
                    <td>${product.revenue}</td>
                     <td>
                        <a href="#" id="openModal2"  onclick="openModal('update-product-modal')"><i class="fas fa-edit"></i></a> 
                        <a href="#"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
            document.getElementById("pageNumber").textContent = currentPage;
            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = endIndex >= products.length;
        }

        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                displayProducts();
            }
        });

        document.getElementById("nextPage").addEventListener("click", () => {
            if ((currentPage * itemsPerPage) < products.length) {
                currentPage++;
                displayProducts();
            }
        });

        displayProducts();

        // modal for update product
        function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        }

    </script>
</body>
</html>