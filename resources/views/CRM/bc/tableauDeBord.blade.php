@include('CRM.header')
@include('CRM.sidebar')
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }

    .dashboard-container {
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }

    .filters {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .filters label,
    .filters select,
    .filters input,
    .filters .search-button {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .search-button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        border: none;
    }

    .info-panel {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }

    .info-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 20%;
        font-weight: bold;
    }

    .transit-panel {
        margin-bottom: 20px;
    }

    .transit-header {
        width: 100%;
        background-color: #ffb6c1;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .transit-cards {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .transit-card {
        background-color: #fff;
        padding: 10px;
        border-radius: 4px;
        text-align: center;
        margin: 2px;
        flex: 1;
        min-width: calc(18% - 4px);
        max-width: calc(18% - 4px);
        color: #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 12px;
    }

    .dashboard {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .category {
        flex: 1;
        min-width: 300px;
    }

    .category-title {
        background-color: #6a1b9a;
        color: white;
        padding: 10px;
        border-radius: 4px 4px 0 0;
        text-align: center;
        font-weight: bold;
    }

    .stat-box {
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 4px;
        color: #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
</style>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerBc')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
        <div class="dashboard-container">
            <div class="filters">
                <label>Date: <input type="date"></label>
                <label>Client:
                    <select>
                        <option>Client 1</option>
                        <option>Client 2</option>
                    </select>
                </label>
                <label>Saison:
                    <select>
                        <option>Été</option>
                        <option>Hiver</option>
                    </select>
                </label>
                <label>Modèle:
                    <select>
                        <option>Modèle A</option>
                        <option>Modèle B</option>
                    </select>
                </label>
                <label>État:
                    <select>
                        <option>Actif</option>
                        <option>Inactif</option>
                    </select>
                </label>
                <button class="search-button">Rechercher</button>
            </div>

            <div class="info-panel">
                <div class="info-card">TOTAL BC<br>8</div>
                <div class="info-card">RECAP RÉCLAMATION<br>1</div>
                <div class="info-card">TOTAL BC.CT<br>2</div>
            </div>

            <div class="transit-panel">
                <div class="transit-header">TRANSIT</div>
                <div class="transit-cards">
                    <div class="transit-card" style="background-color: #32CD32">ARRIVÉE<br>0.00 %<br>0</div>
                    <div class="transit-card" style="background-color: #dcdcdc">EN-COURS<br>100.00 %<br>2</div>
                    <div class="transit-card" style="background-color: #FF4500">RETARD<br>100.00 %<br>2</div>
                    <div class="transit-card" style="background-color: #4682B4">LIVRÉE PARTIEL<br>0.00 %<br>0</div>
                    <div class="transit-card" style="background-color: #FFA500">ANNULÉE<br>0.00 %<br>0</div>
                </div>
            </div>

            <div class="dashboard">
                <div class="category">
                    <div class="category-title">TISSU</div>
                    <div class="stat-box" style="background-color: #f0e68c">0.00 % - NB ARTICLE LIVRÉE 100%<br>0</div>
                    <div class="stat-box" style="background-color: #ff6347">22.22 % - NB RETARD<br>2</div>
                    <div class="stat-box" style="background-color: #4682b4">11.11 % - NB ARTICLE LIVRÉE PARTIEL<br>1
                    </div>
                    <div class="stat-box" style="background-color: #dcdcdc">88.89 % - NB ARTICLE EN-COURS<br>8</div>
                </div>

                <div class="category">
                    <div class="category-title">ACCESSOIRE</div>
                    <div class="stat-box" style="background-color: #f0e68c">0.00 % - NB ARTICLE LIVRÉE 100%<br>0</div>
                    <div class="stat-box" style="background-color: #ff6347">0.00 % - NB RETARD<br>0</div>
                    <div class="stat-box" style="background-color: #4682b4">0.00 % - NB ARTICLE LIVRÉE PARTIEL<br>0
                    </div>
                    <div class="stat-box" style="background-color: #dcdcdc">100.00 % - NB ARTICLE EN-COURS<br>1</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@include('CRM.footer')
