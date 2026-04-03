<?php
require_once 'TransferBank.php';
require_once 'EWallet.php';
require_once 'QRIS.php';
require_once 'COD.php';
require_once 'VirtualAccount.php';

$hasil_proses = "";
$hasil_struk = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nominal = $_POST['nominal'];
    $metode = $_POST['metode'];

    $pembayaran = null;

    if ($metode == "TransferBank") {
        $pembayaran = new TransferBank($nominal);
    } elseif ($metode == "EWallet") {
        $pembayaran = new EWallet($nominal);
    } elseif ($metode == "QRIS") {
        $pembayaran = new QRIS($nominal);
    } elseif ($metode == "COD") {
        $pembayaran = new COD($nominal);
    } elseif ($metode == "VirtualAccount") {
        $pembayaran = new VirtualAccount($nominal);
    }

    if ($pembayaran != null) {
        $hasil_proses = $pembayaran->prosesPembayaran();
        $hasil_struk = $pembayaran->cetakStruk();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembayaran Online</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #2ff7c2, #0793f1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2ff7cf;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #07c6f1;
            outline: none;
            box-shadow: 0 0 5px rgba(7, 26, 241, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #2ff79a, #07f1f1);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f9f9f9;
            border-left: 5px solid #2ff79a;
            animation: fadeIn 0.5s ease-in-out;
        }

        .result strong {
            color: #333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>💳 Pembayaran Online</h2>

        <form method="POST" action="">
            <label for="nominal">Masukkan Nominal (Rp)</label>
            <input type="number" id="nominal" name="nominal" min="1" required>

            <label for="metode">Metode Pembayaran</label>
            <select id="metode" name="metode" required>
                <option value="" disabled selected>-- Pilih Metode --</option>
                <option value="TransferBank">Transfer Bank</option>
                <option value="EWallet">E-Wallet</option>
                <option value="QRIS">QRIS</option>
                <option value="COD">Cash On Delivery (COD)</option>
                <option value="VirtualAccount">Virtual Account</option>
            </select>

            <button type="submit">Bayar Sekarang</button>
        </form>

        <?php if (!empty($hasil_proses)): ?>
            <div class="result">
                <p><strong>Status:</strong> <?= $hasil_proses ?></p>
                <p><strong>Detail Struk:</strong><br><?= $hasil_struk ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>