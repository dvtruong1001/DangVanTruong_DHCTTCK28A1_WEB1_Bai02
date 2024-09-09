<?php

require_once "config.php";

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

        <div class="row">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $manganh = $_POST["nganhhoc"];

                $tblnganh = $conn->prepare("select * from tblnganh where maNganh = ?");
                $tblnganh->bind_param("s", $manganh);

                $tblnganh->execute();

                $tblnganh_rl = $tblnganh->get_result();

                if ($tblnganh_rl->num_rows > 0) {

                    $tblnganh_row = $tblnganh_rl->fetch_assoc();


                    $hocvien = $conn->prepare("select * from tblghidanh where maNganh = ?");

                    $hocvien->bind_param("s", $manganh);
                    $hocvien->execute();

                    $result = $hocvien->get_result();
                    if ($result->num_rows > 0) {



                        ?>
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr colspan="5">
                                        <center><span class="text-uppercase">danh sách học viên ngành : <span class="fw-bold"><?=$tblnganh_row["tenNganh"];?></span>  </span></center>
                                    </tr>
                                    <tr>
                                        <th scope="col">TT</th>
                                        <th scope="col">Mã ghi danh</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Ngày sinh</th>
                                        <th scope="col">Giới tính</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stt = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $stt++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $stt; ?></th>
                                            <td><?= $row["maGhiDanh"]; ?></td>
                                            <td><?= $row["hovaten"]; ?></td>
                                            <td><?= $row["ngaysinh"]; ?></td>
                                            <td><?= $row["gioitinh"]; ?></td>
                                        </tr>

                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="4">Tổng số : </td>
                                        <td><?= $result->num_rows; ?> HV</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php
                    }
                }
            }
            ?>
            <div class="col-12 text-center">
                <div class="row">
                    <form action="" method="POST">
                        <div class="col-12 mb-3">
                            <label for="">Chọn mã ngành muốn xem</label>

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

                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" name="view">
                                Xem
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>



</body>

</html>