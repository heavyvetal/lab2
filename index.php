<?php

$isAdmin = false;

if (
    isset($_GET['login']) && isset($_GET['password']) &&
    $_GET['login'] == 'admin' && $_GET['password'] == 'admin'
) {
    $isAdmin = true;
}

$posts = json_decode(file_get_contents('db.json'), true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.edition').click(function () {
                const parentPost = $(this).parents('.post')
                const postText = parentPost.children('.topwrap').children('.posttext')

                let text = $.trim(postText.children('p').text());

                $(this).parent().children('.save').show()
                $(this).hide()

                postText.html(`
                    <div class="textwraper">
                        <textarea class="editor">${text}</textarea>
                    </div>
               `)
            })

            $('.delete').click(function () {
                const parentPost = $(this).parents('.post')

                let id = $.trim(parentPost.children('.id').text())

                parentPost.remove()

                $.post('post_processor.php', `id=${id}&del=del`, function (res) {
                    console.log(res)

                    if (res) {
                        alert(res)
                    }
                })
            })

            $('.save').click(function () {
                const parentPost = $(this).parents('.post')

                let text = parentPost
                    .children('.topwrap')
                    .children('.posttext')
                    .children('.textwraper')
                    .children('.editor')
                    .val()

                let id = $.trim(parentPost.children('.id').text())

                $.post('post_processor.php', 'text=' + text + '&id=' + id, function (res) {
                    console.log(res)

                    if (res) {
                        alert(res)
                    }
                })
            })
        })
    </script>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <?php foreach ($posts as $post):?>
            <!-- POST -->
            <div class="post">
                <div class="id">
                    <?php echo $post['id']?>
                </div>
                <div class="topwrap">
                    <div class="userinfo pull-left">
                        <div class="username">
                            <?php echo $post['username']?>
                        </div>
                    </div>
                    <div class="posttext pull-left">
                        <p class="pull-left">
                            <?php echo $post['content']?>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="postinfobot">
                    <div class="posted pull-left">Posted on : <?php echo $post['created_at']?></div>
                    <?php if ($isAdmin):?>
                        <div class="pull-right postreply">
                            <div class="pull-left" style="margin-right: 10px;">
                                <button type="submit" class="edition btn btn-primary">Edit</button>
                                <button type="submit" class="save btn btn-primary">Save</button>
                            </div>
                            <div class="pull-left">
                                <button type="submit" class="delete btn btn-primary">Delete</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php endif;?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- POST -->
            <?php endforeach;?>

        </div>
        <div class="col-lg-4 col-md-4">
            <div class="sidebarblock">
                <h3>Categories</h3>
                <div class="divline"></div>
                <div class="blocktxt">
                    <ul class="cats">
                        <li><a href="#">Trading for Money <span class="badge pull-right">20</span></a></li>
                        <li><a href="#">Vault Keys Giveway <span class="badge pull-right">10</span></a></li>
                        <li><a href="#">Misc Guns Locations <span class="badge pull-right">50</span></a></li>
                        <li><a href="#">Looking for Players <span class="badge pull-right">36</span></a></li>
                        <li><a href="#">Stupid Bugs &amp; Solves <span class="badge pull-right">41</span></a></li>
                        <li><a href="#">Video &amp; Audio Drivers <span class="badge pull-right">11</span></a></li>
                        <li><a href="#">2K Official Forums <span class="badge pull-right">5</span></a></li>
                    </ul>
                </div>
            </div>

            <!-- -->
            <div class="sidebarblock">
                <h3>Poll of the Week</h3>
                <div class="divline"></div>
                <div class="blocktxt">
                    <p>Which game you are playing this week?</p>
                    <form action="#" method="post" class="form">
                        <table class="poll">
                            <tbody><tr>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar color1" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                            Call of Duty Ghosts
                                        </div>
                                    </div>
                                </td>
                                <td class="chbox">
                                    <input id="opt1" type="radio" name="opt" value="1">
                                    <label for="opt1"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar color2" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 63%">
                                            Titanfall
                                        </div>
                                    </div>
                                </td>
                                <td class="chbox">
                                    <input id="opt2" type="radio" name="opt" value="2" checked="">
                                    <label for="opt2"></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar color3" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                            Battlefield 4
                                        </div>
                                    </div>
                                </td>
                                <td class="chbox">
                                    <input id="opt3" type="radio" name="opt" value="3">
                                    <label for="opt3"></label>
                                </td>
                            </tr>
                            </tbody></table>
                    </form>
                    <p class="smal">Voting ends on 19th of October</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>






