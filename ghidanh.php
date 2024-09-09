<?php

require_once "config.php";

$success = false;
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save"])) {
        $maGhiDanh = $_POST["maGhiDanh"];
        $hovaten = $_POST["hovaten"];
        $ngaysinh = $_POST["ngaysinh"];
        $gioitinh = $_POST["gioitinh"];
        $dienthoai = $_POST["dienthoai"] ?? "";
        $nganhhoc = $_POST["nganhhoc"];
        $email = $_POST["email"];


        $chk = $conn->prepare("select * from tblghidanh where maGhiDanh = ?");
        $chk->bind_param("s", $maGhiDanh);
        $chk->execute();

        $row = $chk->get_result();
        if ($row->num_rows > 0) {
            $success = false;
            $msg = "Mã ghi danh này đã tồn tại trong cơ sở dữ liệu";
        } else {

            $sql = "insert into tblghidanh (maGhiDanh, hovaten, ngaysinh, gioitinh, dienthoai, email, maNganh) values (?, ?, ?, ?, ?, ?, ?)";

            $chen = $conn->prepare($sql);
            $chen->bind_param("sssssss", $maGhiDanh, $hovaten, $ngaysinh, $gioitinh, $dienthoai, $email, $nganhhoc);
            $chen->execute();
            $success = true;
            $msg = "Đã ghi danh thành công";

        }

    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Ghi danh</title>
</head>

<body>

    <div class="container">
        <div class="row gy-3">
            <form action="" method="post">

                <div class="col-12 text-center">
                    <span class="text-uppercase fw-bold fs-3">
                        thông tin ghi danh
                    </span>
                </div>
                <?php

                if ($success) {
                    ?>
                    <div class="col-12">
                        <div class="alert alert-success">
                            <?= $msg; ?>
                        </div>
                    </div>
                    <?php
                } else {
                    if ($msg) {


                        ?>
                        <div class="alert alert-warning">
                            <?=$msg;?>
                        </div>
                        <?php
                    }
                }

                ?>
                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            Mã ghi danh :
                        </div>
                        <div class="col-auto text-right">
                            <input class="form-control" type="text" name="maGhiDanh" required>
                        </div>
                        <div class="col-auto">
                            <span>(*)</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            Họ và tên :
                        </div>
                        <div class="col-auto text-right">
                            <input class="form-control" type="text" name="hovaten" required>
                        </div>
                        <div class="col-auto">
                            <span>(*)</span>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            Ngày sinh :
                        </div>
                        <div class="col-auto text-right">
                            <input class="form-control" type="date" name="ngaysinh" required>
                        </div>
                        <div class="col-auto">
                            <span>(*)</span>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-auto">
                                    <span>Giới tính :</span>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" name="gioitinh" required>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            Điện thoại :
                        </div>
                        <div class="col-auto text-right">
                            <input class="form-control" name="dienthoai" type="text">
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <span>Email :</span>
                                </div>
                                <div class="col-auto">
                                    <input class="form-control" type="email" name="email" id="" required>
                                </div>
                                <div class="col-auto">
                                    <span>(*)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            <span>Ngành học</span>
                        </div>
                        <div class="col-auto">
                            <?php
                            $nganhhoc = $conn->query("select * from tblnganh");
                            ?>
                            <select name="nganhhoc" id="" class="form-select" size="<?= $nganhhoc->num_rows; ?>">

                                <?php
                                while ($row = $nganhhoc->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row["maNganh"] ?>"><?= $row["tenNganh"]; ?></option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                        <div class="col-auto">
                            <span>(*)</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-2">

                        </div>
                        <div class="col-10">
                            <button class="btn btn-primary save-btn" name="save" type="submit">
                                Lưu
                            </button>
                        </div>
                    </div>
                </div>

            </form>




        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>



</body>

</html>