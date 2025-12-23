<?php
session_start();
include '../php/connection.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] != "loginadmin") {
    header("Location: index.php?pesan=belum_login");
    exit();
}
$search = '';
$report = mysqli_query($conn,"SELECT * FROM report");
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $report = mysqli_query($conn,"SELECT * FROM report WHERE projectId LIKE '%$search%'");
}

if (isset($_GET['type'])) {
    $search = $_GET['type'];
    $report = mysqli_query($conn,"SELECT * FROM report WHERE reportType LIKE '%$search%'");
}

if (isset($_GET['kosong'])) {
    $report = mysqli_query($conn,"SELECT * FROM report");
}

$i = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Admin</title>
</head>
<link rel="stylesheet" href="../style/admin-home.css">
<link rel="stylesheet" href="../style/global.css">

<link rel="stylesheet" href="../style/style-detail-project.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" href="../asset/logo/logo_1.png">
<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin="crossorigin">
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
<body>

<div class="content">
    <div class="side-bar">
        <div class="content-side-bar-head">
            <div class="img-casepose"></div>
        </div>
        <div class="side-bar-navigation">

            <a href="home.php"><div class="list-navigation ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.9548 5.54274C17.8848 3.48516 15.0963 2.31255 12.1779 2.27254C9.25956 2.23253 6.43989 3.32825 4.31431 5.32832C2.18874 7.32839 0.923642 10.0762 0.786178 12.9916C0.648714 15.907 1.64964 18.7617 3.57759 20.9529L3.58603 20.9623C3.6015 20.9787 3.61603 20.9956 3.6329 21.0115C3.66759 21.0509 3.70697 21.0954 3.75337 21.1418C3.93537 21.3352 4.15533 21.489 4.39949 21.5935C4.64366 21.6981 4.90677 21.7511 5.17236 21.7492C5.43794 21.7474 5.70029 21.6907 5.94298 21.5828C6.18566 21.4749 6.40346 21.3181 6.58275 21.1221C7.27259 20.3724 8.11047 19.7739 9.04342 19.3646C9.97637 18.9552 10.9841 18.7438 12.0029 18.7438C13.0217 18.7438 14.0294 18.9552 14.9624 19.3646C15.8953 19.7739 16.7332 20.3724 17.4231 21.1221C17.6037 21.3191 17.8232 21.4764 18.0678 21.5842C18.3124 21.6919 18.5767 21.7476 18.8439 21.7479C19.1112 21.7482 19.3756 21.6929 19.6204 21.5857C19.8652 21.4785 20.085 21.3216 20.266 21.1249L20.4165 20.9609L20.4249 20.9515C22.3246 18.8064 23.3338 16.0172 23.2467 13.1532C23.1596 10.2892 21.9827 7.56651 19.9562 5.54087L19.9548 5.54274ZM11.2501 5.99977C11.2501 5.80086 11.3291 5.61009 11.4698 5.46944C11.6104 5.32879 11.8012 5.24977 12.0001 5.24977C12.199 5.24977 12.3898 5.32879 12.5304 5.46944C12.6711 5.61009 12.7501 5.80086 12.7501 5.99977V7.49977C12.7501 7.69868 12.6711 7.88945 12.5304 8.0301C12.3898 8.17075 12.199 8.24977 12.0001 8.24977C11.8012 8.24977 11.6104 8.17075 11.4698 8.0301C11.3291 7.88945 11.2501 7.69868 11.2501 7.49977V5.99977ZM6.00009 14.2498H4.50009C4.30118 14.2498 4.11041 14.1708 3.96976 14.0301C3.82911 13.8895 3.75009 13.6987 3.75009 13.4998C3.75009 13.3009 3.82911 13.1101 3.96976 12.9694C4.11041 12.8288 4.30118 12.7498 4.50009 12.7498H6.00009C6.199 12.7498 6.38977 12.8288 6.53042 12.9694C6.67107 13.1101 6.75009 13.3009 6.75009 13.4998C6.75009 13.6987 6.67107 13.8895 6.53042 14.0301C6.38977 14.1708 6.199 14.2498 6.00009 14.2498ZM8.28759 9.78727C8.14695 9.92782 7.95626 10.0068 7.75744 10.0068C7.55861 10.0068 7.36792 9.92782 7.22728 9.78727L6.1665 8.72696C6.02583 8.58629 5.9468 8.3955 5.9468 8.19657C5.9468 7.99763 6.02583 7.80685 6.1665 7.66618C6.30717 7.52551 6.49795 7.44648 6.69689 7.44648C6.89582 7.44648 7.08661 7.52551 7.22728 7.66618L8.28759 8.72696C8.42814 8.8676 8.50709 9.05829 8.50709 9.25712C8.50709 9.45594 8.42814 9.64663 8.28759 9.78727ZM15.286 10.8701L13.0595 14.4091C12.9684 14.5354 12.8576 14.6462 12.7313 14.7373C12.4266 14.9499 12.0502 15.0337 11.684 14.9706C11.3178 14.9075 10.9913 14.7025 10.7753 14.4001C10.5593 14.0977 10.4713 13.7223 10.5303 13.3554C10.5894 12.9885 10.7907 12.6597 11.0907 12.4404L14.6298 10.2138C14.7102 10.1578 14.8059 10.1277 14.904 10.1277C15.0021 10.1277 15.0978 10.1578 15.1782 10.2138C15.2793 10.2868 15.3473 10.3968 15.3675 10.5197C15.3877 10.6427 15.3584 10.7686 15.286 10.8701ZM16.7729 9.78727C16.6311 9.92199 16.4423 9.99598 16.2467 9.99348C16.0512 9.99097 15.8643 9.91217 15.726 9.77387C15.5877 9.63557 15.5089 9.44871 15.5064 9.25314C15.5039 9.05757 15.5779 8.86876 15.7126 8.72696L16.7729 7.66618C16.9136 7.52551 17.1044 7.44648 17.3033 7.44648C17.5022 7.44648 17.693 7.52551 17.8337 7.66618C17.9744 7.80685 18.0534 7.99763 18.0534 8.19657C18.0534 8.3955 17.9744 8.58629 17.8337 8.72696L16.7729 9.78727ZM19.5001 14.2498H18.0001C17.8012 14.2498 17.6104 14.1708 17.4698 14.0301C17.3291 13.8895 17.2501 13.6987 17.2501 13.4998C17.2501 13.3009 17.3291 13.1101 17.4698 12.9694C17.6104 12.8288 17.8012 12.7498 18.0001 12.7498H19.5001C19.699 12.7498 19.8898 12.8288 20.0304 12.9694C20.1711 13.1101 20.2501 13.3009 20.2501 13.4998C20.2501 13.6987 20.1711 13.8895 20.0304 14.0301C19.8898 14.1708 19.699 14.2498 19.5001 14.2498Z" fill="#0F172A"/>
                </svg>
                Dashboard
            </div></a>

            <a href="project.php"><div class="list-navigation ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>

                Project
            </div></a>

            <a href="report.php"><div class="list-navigation active">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3.375 3C2.33947 3 1.5 3.83947 1.5 4.875V5.625C1.5 6.66053 2.33947 7.5 3.375 7.5H20.625C21.6605 7.5 22.5 6.66053 22.5 5.625V4.875C22.5 3.83947 21.6605 3 20.625 3H3.375Z" fill="#0F172A"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.08679 9L3.62657 18.1762C3.71984 19.7619 5.03296 21 6.62139 21H17.3783C18.9667 21 20.2799 19.7619 20.3731 18.1762L20.9129 9H3.08679ZM9.24976 12.75C9.24976 12.3358 9.58554 12 9.99976 12H13.9998C14.414 12 14.7498 12.3358 14.7498 12.75C14.7498 13.1642 14.414 13.5 13.9998 13.5H9.99976C9.58554 13.5 9.24976 13.1642 9.24976 12.75Z" fill="#0F172A"/>
                </svg>
                Report
            </div></a>
            <a href="tambah-type.php"><div class="list-navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3.375 3C2.33947 3 1.5 3.83947 1.5 4.875V5.625C1.5 6.66053 2.33947 7.5 3.375 7.5H20.625C21.6605 7.5 22.5 6.66053 22.5 5.625V4.875C22.5 3.83947 21.6605 3 20.625 3H3.375Z" fill="#0F172A"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.08679 9L3.62657 18.1762C3.71984 19.7619 5.03296 21 6.62139 21H17.3783C18.9667 21 20.2799 19.7619 20.3731 18.1762L20.9129 9H3.08679ZM9.24976 12.75C9.24976 12.3358 9.58554 12 9.99976 12H13.9998C14.414 12 14.7498 12.3358 14.7498 12.75C14.7498 13.1642 14.414 13.5 13.9998 13.5H9.99976C9.58554 13.5 9.24976 13.1642 9.24976 12.75Z" fill="#0F172A"/>
                </svg>
                Insert Project Type
            </div></a>
        </div>

        <a href="../php/admin/log-out-admin.php"><div class="list-logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C5.20435 2 4.44129 2.31607 3.87868 2.87868C3.31607 3.44129 3 4.20435 3 5V19C3 19.7956 3.31607 20.5587 3.87868 21.1213C4.44129 21.6839 5.20435 22 6 22H12C12.7956 22 13.5587 21.6839 14.1213 21.1213C14.6839 20.5587 15 19.7956 15 19V5C15 4.20435 14.6839 3.44129 14.1213 2.87868C13.5587 2.31607 12.7956 2 12 2H6ZM16.293 7.293C16.4805 7.10553 16.7348 7.00021 17 7.00021C17.2652 7.00021 17.5195 7.10553 17.707 7.293L21.707 11.293C21.8945 11.4805 21.9998 11.7348 21.9998 12C21.9998 12.2652 21.8945 12.5195 21.707 12.707L17.707 16.707C17.5184 16.8892 17.2658 16.99 17.0036 16.9877C16.7414 16.9854 16.4906 16.8802 16.3052 16.6948C16.1198 16.5094 16.0146 16.2586 16.0123 15.9964C16.01 15.7342 16.1108 15.4816 16.293 15.293L18.586 13H10C9.73478 13 9.48043 12.8946 9.29289 12.7071C9.10536 12.5196 9 12.2652 9 12C9 11.7348 9.10536 11.4804 9.29289 11.2929C9.48043 11.1054 9.73478 11 10 11H18.586L16.293 8.707C16.1055 8.51947 16.0002 8.26516 16.0002 8C16.0002 7.73484 16.1055 7.48053 16.293 7.293Z" fill="#E11D48"/>
            </svg>
            <label for="">Logout</label>
        </div></a>
    </div>

    <div class="main-content">
        <div class="main-content-head">
            <label for="">Report</label>
        </div>

        <div class="main-content-1">
            <div class="overview">
                <label for="" class="bold">Report</label>
                <div style="display:flex;gap:20px;">
                    <div>
                        <form action="report.php">
                            <input type="text" value="" name="kosong" hidden>
                            <button type="submit" id="btn-view-all" >view All</button>
                        </form>
                    </div>
                    <div>
                        <form action="report.php" method="get">
                            <select name="type" id="" class="input-admin">
                                <option value=""selected disabled>Select by Type</option>
                                <option value="Spam">Spam</option>
                                <option value="Fraud or Scam">Fraud or Scam</option>
                                <option value="Harmful or Illegal">Harmful or Illegal</option>
                                <option value="Misinformation">Misinformation</option>
                                <option value="Other">Other</option>
                            </select>
                            <button type="submit" >Search</button>
                        </form>
                    </div> 
                    <div>
                        <form action="report.php" method="get">
                            <input type="text" name="search" placeholder="search by project ID"><button type="submit" >Search</button>
                        </form>
                    </div> 
                </div>
                
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Project ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($rows = mysqli_fetch_assoc($report)) :?>
                    <tr>
                        <td><?php echo $i++?></td>
                        <td><?php echo $rows["reportType"]?></td>
                        <td><?php echo $rows["reportDescription"]?></td>
                        <td><?php echo $rows["reportStatus"]?></td>
                        <td><?php echo $rows["projectId"]?></td>
                        <td>
                            <div class="div-btn">
                                <div class="btn-edit" onclick="notifikasiReport()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                        <path d="M14.4874 1.92956C13.804 1.24614 12.696 1.24614 12.0126 1.92956L11.2411 2.70099L13.716 5.17587L14.4874 4.40443C15.1709 3.72101 15.1709 2.61297 14.4874 1.92956Z" fill="white"/>
                                        <path d="M13.0089 5.88297L10.534 3.4081L2.43347 11.5087C2.02228 11.9199 1.72002 12.427 1.55401 12.9843L1.02082 14.7742C0.968408 14.9502 1.01664 15.1407 1.14646 15.2705C1.27628 15.4004 1.4668 15.4486 1.64276 15.3962L3.43268 14.863C3.99 14.697 4.49716 14.3947 4.90836 13.9835L13.0089 5.88297Z" fill="white"/>
                                    </svg>Edit</div> 
                                <div class="btn-delete" onclick="notifikasiReport2()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00002 1.2168C5.785 1.2168 4.80002 2.20177 4.80002 3.4168V3.77095C4.1638 3.83257 3.53284 3.91237 2.90769 4.00983C2.58027 4.06088 2.35623 4.36768 2.40727 4.69509C2.45832 5.02251 2.76512 5.24655 3.09253 5.19551L3.21086 5.17729L3.88406 13.5922C3.97553 14.7356 4.93006 15.6168 6.07705 15.6168H9.92283C11.0698 15.6168 12.0244 14.7356 12.1158 13.5922L12.789 5.17724L12.9077 5.19551C13.2351 5.24655 13.5419 5.02251 13.5929 4.69509C13.644 4.36768 13.42 4.06088 13.0925 4.00983C12.4673 3.91236 11.8363 3.83256 11.2 3.77094V3.4168C11.2 2.20177 10.2151 1.2168 9.00002 1.2168H7.00002ZM8.00011 3.6168C8.67159 3.6168 9.33843 3.63698 10 3.67679V3.4168C10 2.86451 9.55231 2.4168 9.00002 2.4168H7.00002C6.44774 2.4168 6.00002 2.86451 6.00002 3.4168V3.6768C6.66168 3.63699 7.32857 3.6168 8.00011 3.6168ZM7.01349 6.58682C6.99693 6.17294 6.64799 5.85084 6.23411 5.8674C5.82023 5.88395 5.49813 6.23289 5.51469 6.64677L5.7547 12.6468C5.77125 13.0607 6.12019 13.3828 6.53407 13.3662C6.94796 13.3496 7.27005 13.0007 7.2535 12.5868L7.01349 6.58682ZM10.4855 6.64677C10.5021 6.23289 10.18 5.88395 9.76607 5.8674C9.35219 5.85084 9.00325 6.17294 8.9867 6.58682L8.7467 12.5868C8.73014 13.0007 9.05224 13.3496 9.46612 13.3662C9.88 13.3828 10.2289 13.0607 10.2455 12.6468L10.4855 6.64677Z" fill="white"/>
                                    </svg>Delete</div>
                            </div>
                        </td>
                        <script src="../javascript/admin.js"></script>
                        <div class="bg-pop-up" id="notif-1" style="display: none;">
                            <form action="../php/admin/proses-report.php" method="post">
                            <div class="edit-report">
                                <div class="edit-report-head">
                                    <label for="" class="bld">Change Status</label>
                                </div>
                                <div class="edit-report-content">
                                    <label for="" class="bold">Project Id</label><br>
                                    <div class="input-notif">
                                        <label for="" class="bold"><?php echo $rows["projectId"];?></label>
                                    </div>
                                    <input type="text" name="projectId" class="input-notif" value="<?php echo $rows["projectId"];?>" hidden>
                                    <label for="" class="bold">Report Status</label><br>
                                    <select name="status" id="" class="input-notif-2">
                                        <option value="<?php echo $rows["reportStatus"]?>" selected><?php echo $rows["reportStatus"]?></option>
                                        <option value="DONE">DONE</option>
                                        <option value="ON RIVIEW">ON RIVIEW</option>
                                        <option value="DECLINED">DECLINED</option>
                                    </select>
                                </div>
                                <div class="edit-report-btn">
                                    <div class="btn-cancel" onclick="notifikasiBack('notif-1')">Cancel</div>
                                    <button type="submit" class="btn-change">Change</button>
                                </div>
                            </div>
                            </form>
                        </div>

                        <div class="bg-pop-up" id="notif-2" style="display: none;">
                            <form action="../php/admin/delete-report.php" method="post">
                            <div class="edit-report">
                                <div class="edit-report-head">
                                    <label for="" class="bld">Confirmation</label>
                                </div>
                                <div class="div-notif-delete">
                                    <label for="" class="bold">Are you sure</label><br>
                                    <label for="">Want to Delete this Report?</label>
                                </div>
                                <!-- disembunyikan -->
                                 <input type="text" value="<?php echo $rows["projectId"];?>" name="projectId" hidden>
                                <div class="edit-report-btn">
                                    <div class="btn-cancel" onclick="notifikasiBack('notif-2')">Cancel</div>
                                    <button type="submit" class="btn-delete-2">Delete</button>
                                </div>
                            </div>
                            </form>
                        </div>

                    </tr>
                    <?php endwhile ;?>
                </tbody>
            </table>
        </div>
    </div>

</div>


</body>
</html>