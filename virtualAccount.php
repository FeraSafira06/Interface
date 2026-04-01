<?php
require_once 'Pembayaran.php';
require_once 'Cetak.php';

class VirtualAccount extends Pembayaran implements Cetak {

    public function prosesPembayaran() {
        if ($this->validasi()) {
            return "Pembayaran Virtual Account Rp {$this->jumlah} berhasil";
        }
        return "Jumlah tidak valid";
    }

    public function cetakStruk() {
        return "Struk VA: Rp {$this->jumlah}";
    }
}