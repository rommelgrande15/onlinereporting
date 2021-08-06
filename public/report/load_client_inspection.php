<?php
    include 'controller/controller.php';
    $id=$_GET['id'];
?>
<table class="table table-hover" id="client_inspec_tables">
    <thead class="text-warning">
        <th>Report / Reference Number</th>
        <th>Inspection Date</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php
            $inspec=selectClientInspection($id);
            foreach($inspec as $result){   
        ?>
        <tr>
            <td><?= $result['gen_refnum']; ?></td>
            <td><?= date('F d, Y', strtotime($result['gen_insdate'])); ?></td>
            <td><button class="btn btn-rose" onclick="window.location.href='upload.php?id=<?= $result['gen_id'];?>&comp_id=<?= $id; ?>'"><i class="fa fa-eye"></i>  View</button></td>
        </tr>
        <?php
           }   
        ?>

        <?php
            $inspec=selectClientInspectionHardCoded($id);
            foreach($inspec as $result){   
        ?>
        <tr>
            <td><?= $result['reference_num']; ?></td>
            <td><?= date('F d, Y', strtotime($result['inspection_date']));?></td>
            <td><button class="btn btn-rose" onclick="window.location.href='edit-upload.php?comp_id=<?= $id; ?>&ref_num=<?= $result['reference_num']; ?>'"><i class="fa fa-eye"></i>  View</button></td>
        </tr>
        <?php
           }   
        ?>
    </tbody>
</table>
