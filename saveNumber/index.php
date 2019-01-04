<!DOCTYPE html>
<html>
<head>
  <title>Номера</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../bootsrap/css/bootstrap.min.css">
  <style>
  td {
    background-color: cyan;
  }
  #page {
    width:5em;
  }

  </style>
</head>
<body>
  <div class="container">

  <table class="table table-bordered table-sm">
    <thead class="thead-dark">
     <tr>
        <th>К</th>
        <th>S</th>
        <th colspan="2">Эт</th>
        <th>&#x20BD;</th>
        <th>&#x20BD;/M<sup>2</sup></th>
        <th>дата</th>
        <th>адрес</th>
     </tr>
  </thead>
  <tbody>
  </tbody>
  <tr>
    <td>1</td>
    <td>40</td>
    <td colspan="2">3/4</td>
    <td>98000</td>
    <td>23000</td>
    <td>03.0.4.2018</td>
    <td>Остроквкого, 6</td>
  </tr>
  </table>

    <nav >
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a id="prev" class="page-link" href="#" onclick="fff(this)">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item">
          <input id="page" value="0" class="form-control" type="text">
        </li>
        <li class="page-item">
          <a id="next" class="page-link" href="#" aria-label="Next" onclick="fff(this)">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
        <li class="page-item">
          <a id="okPage" class="page-link" href="#" onclick="fff(this)">ok</a>
        </li>
      </ul>
    </nav>
  </div>
  <script>
  /*
  количество страниц создается после запроса 
  */
    var paga = document.getElementById('page');
    function fff(e) {

    var id = e.id;
    var page = document.getElementById('page');

    /*if (id=="prev") {
        page.value--;
      } else if (id=="next") {
        page.value++;
      }
*/
    switch (id) {
      case "prev":
      if(page.value!=1) page.value--;

      break;
      case "next":

      page.value++;
      break;
    }

        //  alert(page.value);
    /*  } else if (id=="okPage") {

    } */
}
  </script>
</body>
</html>
