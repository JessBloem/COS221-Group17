<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wines</title>
    <link rel="stylesheet" href="css/index.css">
</head>



<body>
    <?php include_once "header.php"; ?>
    
    <main>
        <select id="winesort" value="Name">
            <option value="Name">Name</option>
            <option value="Age">Age</option>
            <option value="Alchohol Percentage">Alchohol Percentage</option>
            <option value="Quality">Quality</option>
            <option value="Rating">Rating</option>
        </select>

        <select id="sortorder" value="Asc">
            <option value="Asc">Asc</option>
            <option value="Desc">Desc</option>
        </select>


        <select id="wineryfilter">
            <option value="Chamonix Estate">Chamonix Estate</option>
            <option value="Groot Post Vineyards">Groot Post Vineyards</option>
            <option value="Klawer Wine Cellars">Klawer Wine Cellars</option>
            <option value="Kleine Zalze Wines">Kleine Zalze Wines</option>
            <option value="Koelenhof Wine Cellar">Koelenhof Wine Cellar</option>
            <option value="La Motte">La Motte</option>
            <option value="Laborie Wines">Laborie Wines</option>
            <option value="Nederburg Wines">Nederburg Wines</option>
            <option value="Orange River Wines">Orange River Wines</option>
            <option value="Perdeberg Wines">Perdeberg Wines</option>
            <option value="Raka Wines">Raka Wines</option>
            <option value="Roodeberg">Roodeberg</option>
        </select>


        <select id="typefilter">
            <option value="Bin Edelkeur">Bin Edelkeur</option>
            <option value="Blend">Blend</option>
            <option value="Cabernet Sauvignon">Cabernet Sauvignon</option>
            <option value="Chardonnay">Chardonnay</option>
            <option value="Chenin Blanc">Chenin Blanc</option>
            <option value="Colombard">Colombard</option>
            <option value="Grenache Carignan">Grenache Carignan</option>
            <option value="Kleine Zalze Chenin Blanc">Kleine Zalze Chenin Blanc</option>
            <option value="Kleine Zalze Red Blend">Kleine Zalze Red Blend</option>
            <option value="Kleine Zalze Rose Chardonnay">Kleine Zalze Rose Chardonnay</option>
            <option value="Koelenbosch Rose">Koelenbosch Rose</option>
            <option value="Koelenbosch Merlot">Koelenbosch Merlot</option>
            <option value="Koelenbosch Pinorto">Koelenbosch Pinorto</option>
            <option value="Koelenbosch Pinotage">Koelenbosch Pinotage</option>
            <option value="Koelenbosch Red Blend">Koelenbosch Red Blend</option>
            <option value="Koelenbosch Rose Vin-Sec">Koelenbosch Rose Vin-Sec</option>
            <option value="LYRA VEGA">LYRA VEGA</option>
            <option value="Muscat dAlexandrie">Muscat dAlexandrie</option>
            <option value="Perdeberg Red Blend">Perdeberg Red Blend</option>
            <option value="Perdeberg Rose Blend">Perdeberg Rose Blend</option>
            <option value="Perdeberg White Blend">Perdeberg White Blend</option>
            <option value="Pinot Noir">Pinot Noir</option>
            <option value="Pinotage">Pinotage</option>
            <option value="Red Blend" title="Cabernet Sauvignon (55%), Shiraz (45%)">Red Blend</option>


        </select>

        <label>Filter by price:</label>
        <input placeholder="Min Price" id="minprice">
        <input placeholder="Max Price" id="maxprice">



        <select id="brandfilter">
            <option value="Chamonix">Chamonix</option>
            <option value="Klawer Cellars">Klawer Cellars</option>
            <option value="Kleine Zalze">Kleine Zalze</option>
            <option value="Koelenhof Wine Cellar">Koelenhof Wine Cellar</option>
            <option value="KWV Emporium">KWV Emporium</option>
            <option value="La Motte">La Motte</option>
            <option value="Nederburg">Nederburg</option>
            <option value="Orange River">Orange River</option>
            <option value="Perderberg Wines">Perdeberg Wines</option>
        </select>






        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>


        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

        <div class="card">
            <img src="img/winebottle.jpg" width="100px" height="200px">
            <div class="content">
                <h1>Diemersfontein Pinotage</h1>
                <p>Age: 15 years<br>Alchohol Percentage: 14%<br>Quality: Excellent<br>Rating: 5 stars<br>Price: R450</p>
            </div>
        </div>

    </main>






</body>

</html>