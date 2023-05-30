<!DOCTYPE html>
<html lang="en">
<head>
   
    <title>Winery</title>
</head>
<body>
    
<label>Sort by:</label>
<select id = "winerysort" value = "Name">
        <option value = "Name">Name</option>
        <option value = "Area">Area</option>
        <option value = "Rating">Rating</option>
    </select>
    

    <!-- werent sure about the region values, just put provinces down for now... will change -->
<label>Filter by region:</label>
<select id = "regionfilter" >
        <option value = "Gauteng">Gauteng</option>
        <option >Eastern Cape</option>
        <option>Western Cape</option>
        <option>Free State</option>
        <option>Mpumalanga</option>
        <option>Kwazulu-Natal</option>
        <option>Limpopo</option>
        <option>North West</option>
        <option>Northern Cape</option>
    </select>
    



    <label>Filter by rating:</label>
<select id = "ratingfilter" >
        <option value = "5">5 stars and up</option>
        <option value = "4">4 stars and up</option>
        <option value = "3">3 stars and up</option>
        <option value = "2">2 stars and up</option>
        <option value = "1">1 star and up</option>
    </select>


    <br>
    <br>
    
    <div class="card">
            <img src="img/chamonixestate.jpg"  width="400px" height = "200px">
                <div class="content">
                    <h1>Chamonix Estate</h1>
                        <p>Region: Franschoek<br>Rating: 5 stars</p>
                </div>
        </div>


</body>
</html>