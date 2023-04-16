<?php
    session_start();
    if (isset($_GET['limpar'])) {
        unset($_SESSION['buy']);//unset-> Destrói a variável especificada
    }

    $camisas = array(
        ['name' => 'Camisa 01', 'image' => 'uploads/camisa1.jpg', 'price' => '55.90'],
        ['name' => 'Camisa 02', 'image' => 'uploads/camisa2.jpg', 'price' => '45.90'],
        ['name' => 'Camisa 03', 'image' => 'uploads/camisa3.jpg', 'price' => '65.00']
    );    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Virtual</title>
    <!--css-->
    <link rel="stylesheet" href="css/style.css">    
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <nav class="navbar navbar-light bg-danger" >
        <div class="container">
            <a class="navbar-brand" href="#">                
                <img src="img/logo.png" width="50" height="50" alt="" class="d-inline-block align-text-end">
                <span class="text-light">Loja Virtual</span>
            </a>
            
        </div>
    </nav>
    <div class="card-group text-center container">
        <?php foreach ($camisas as $key => $value): ?>
        <div class="card">
            <div class="ratio ratio-1x1">
                <img src="<?=$value['image'] ?>" class="card-img-top" alt="Card Camisas" style="object-fit: contain;" >
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $value['name'] ?></h5>
                <p class="card-text"><?= $value['price'] ?></p>
                <a href="?comprar= <?php echo $key ?>" class="btn btn-warning">COMPRAR</a>
            </div>
        </div>                
        <?php endforeach ?>

    </div>
    <div class="container">
        <?php 
            if (isset($_GET['comprar'])) {
                $idCamisa = (int)$_GET['comprar'];
                if (isset($camisas[$idCamisa])) {
                    if (isset($_SESSION['buy'][$idCamisa])) {
                        $_SESSION['buy'][$idCamisa]['quant']++;                       
                    }else{
                        $_SESSION['buy'][$idCamisa] = array('quant'=>1, 'name'=>$camisas[$idCamisa]['name'], 'price'=>$camisas[$idCamisa]['price']);
                    }
                    echo '<script>alert("Camisa adicionada no carrinho")</script>';
                }else{
                    die("O Produto não está mais no estoque") ;
                }
            }
        ?>
        <h2>Carrinho:</h2>
        <table border="1">
            <tr>
                <th>
                    <?php 
                        if (isset($_SESSION['buy'])) {
                            foreach ($_SESSION['buy'] as $key => $value) {
                                echo '<p>Nome: '.$value['name'].' | Quant.: '.$value['quant'].' | Valor: R$ '.$value['price']*$value['quant'];
                                echo "<br>";
                            }    
                        }else{
                            echo '<script>alert("Item retirado do Carrinho")</script>';
                            echo "O carrinho está vazio!";
                        }
                    ?>
                    <p><a href="?limpar" class="btn btn-secondary">LIMPAR CARRINHO</a></p>
                </th>
            </tr>
        </table>
        <table border="1" style="margin-top: 10px;">
            <tr>
                <th>
                    <?php 

                        $total = [
                            'quants' => 0,
                            'prices' => 0
                        ];
                        if (isset($_SESSION['buy'])) {
                            foreach ($_SESSION['buy'] as $key) {
                                $total['quants'] = $total['quants'] + $key['quant'];
                                $total['prices'] = $total['prices'] + $key['price'] * $key['quant'];
                            }
                            echo $total['quants'] . ' produtos por R$ ' . $total['prices'];
                        }
                    ?>
                </th>
            </tr>
        </table>    
    </div>
    <footer style="border-top: 1px solid #ccc; align-items: center; padding: 20px; margin-top: 20px;">
        <div class="footer" style="display: grid; place-items: center; align-items: center; margin: auto;" >
            <p style="margin: auto; align-items: center; text-align: center;">&copy; Moises - Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
