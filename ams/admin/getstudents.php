<?php
include('../includes/config.php');
if(!empty($_POST["className"])) 
{
 $stdclass= $_POST['className'];
 $stmt = $dbh->prepare("SELECT id,studentName FROM tblstudents WHERE studentClass = :stdclass order by studentName");
 $stmt->execute(array(':stdclass' => $stdclass));
 ?><option value="">Select Student </option><?php
 while($row=$stmt->fetch(PDO::FETCH_ASSOC))
 {
  ?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['studentName']); ?></option>
  <?php
 }

}
?>