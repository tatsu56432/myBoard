<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>MyBoard</title>
</head>
<body>

<h1 class="ttl">MyBoard</h1>

<div class="container">
    <div class="container__inner">

        <div class="inputArea">

            <form action="" method="post">

                <div class="nameInput">

                    <label for="name">名前を入力</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <?php  if(isset($error['name'])) echo '<p class="error">'.$error['name'].'</p>';?>
                </div>

                <div class="commentInput">
                    <label for="comment">コメントを入力</label>
                    <textarea class="form-control" aria-label="With textarea" placeholder="comment" name="comment"></textarea>
                    <?php  if(isset($error['comment'])) echo '<p class="error">'.$error['comment'].'</p>';?>
                </div>

                <p class="submitBtn">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary">
                </p>
            </form>
        </div>

        <ul class="chatItems">
            <li class="chatItem">
                <div class="chatItem__box">
                    <p class="chatItem--name">name:name1</p>
                    <p class="chatItem--date">date:</p>
                    <p class="chatItem--comment">comment:</p>
                </div>
            </li>
            <?php
            if(isset($data)){
                foreach ($data as $val){
                    echo <<<HTML
            <li class="chatItem">
                <div class="chatItem__box">
                    <p class="chatItem--name">name:{$data[0]}</p>
                    <p class="chatItem--date">date:</p>
                    <p class="chatItem--comment">comment:{$data[1]}</p>
                </div>
            </li>
HTML;
                }
            }

            ?>
        </ul>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>