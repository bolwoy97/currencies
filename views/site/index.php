<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Currencies</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

</head>

<body>
    <div class="wrapper">

        <div class="container">
            <div class="jumbotron">
                <h1>Table of currencies </h1>
                <h4>API call 
                <a href="/api/get?id=R01010&from=2020-04-06&to=2020-04-08 ">example</a></h4>
                
                <form class="form-inline" action="" method="post" id="dateForm">
                <h4 class="col-md-1">Dates:</h4>
                 <select onchange="getTable(this.value);" name="date">
                        <?foreach($days_ago as $day_ago):?>
                        <option <?=($date==$day_ago)?'selected':''?> value="<?=$day_ago?>">
                            <?=$day_ago?></option>
                        <?endforeach;?>
                    </select>
                </form>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">valuteID</th>
                                <th scope="col">numCode</th>
                                <th scope="col">сharCode</th>
                                <th scope="col">name</th>
                                <th scope="col">value</th>
                                <th scope="col">date</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            <?require_once(ROOT.'/views/layouts/table.php');?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    function getTable(date) {
        var params={
            date: date,
            table:true
        }
        $.post("/",params, function(data) {
            $("#table").html(data);
        });
    }
    </script>


</body>

</html>