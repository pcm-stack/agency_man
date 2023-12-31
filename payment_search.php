<?php include("../includes/check_session.php");
include("../includes/config.php");
$con=get_connection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Search</title>
<link rel="icon" type="image/x-icon" href="<?php echo $web_path; ?>images/dt-favicon.ico" />
<link href="<?php echo $web_path; ?>css/style.css" rel="stylesheet" type="text/css" />
	<meta charset="UTF-8" />

<script>
  function payment_search_submit(){
    document.getElementById('payment_report').action='payment_search.php';
		document.getElementById('payment_report').submit();

  }

  function excelDownLoad(){
    document.getElementById('payment_report').action='payment_search_display_xls.php';
		document.getElementById('payment_report').submit();

  }
</script>


<script>

function changeDates(){
  //downloadLock();
  var today_date= new Date();
  cur_month=today_date.getMonth()+1;
  cur_year=today_date.getFullYear();
  next_year=cur_year+1;
  prev_year=cur_year-1;
  prev_prev_year=cur_year-2;

  if(cur_month>3){
    cur_year_start_date="01-04-"+cur_year;
    cur_year_end_date="31-03-"+next_year;

    prev_year_start_date="01-04-"+prev_year;
    prev_year_end_date="31-03-"+cur_year;

  }else{
    cur_year_start_date="01-04-"+prev_year;
    cur_year_end_date="31-03-"+cur_year;

    prev_year_start_date="01-04-"+prev_prev_year;
    prev_year_end_date="31-03-"+prev_year;

  }

  document.getElementById('changeDate').value
  if(document.getElementById('changeDate').value=="Previous Year"){
    document.getElementById('bill_start_date').value=prev_year_start_date;
    document.getElementById('bill_end_date').value=prev_year_end_date;
    document.getElementById('changeDate').value="Current Year"


  }else{
    document.getElementById('bill_start_date').value=cur_year_start_date;
    document.getElementById('bill_end_date').value=cur_year_end_date;
    document.getElementById('changeDate').value="Previous Year"

  }
  document.getElementById('bill_start_date').focus();
  
}


function changeDatesVou(){
  //downloadLock();
  var today_date= new Date();
  cur_month=today_date.getMonth()+1;
  cur_year=today_date.getFullYear();
  next_year=cur_year+1;
  prev_year=cur_year-1;
  prev_prev_year=cur_year-2;

  if(cur_month>3){
    cur_year_start_date="01-04-"+cur_year;
    cur_year_end_date="31-03-"+next_year;

    prev_year_start_date="01-04-"+prev_year;
    prev_year_end_date="31-03-"+cur_year;

  }else{
    cur_year_start_date="01-04-"+prev_year;
    cur_year_end_date="31-03-"+cur_year;

    prev_year_start_date="01-04-"+prev_prev_year;
    prev_year_end_date="31-03-"+prev_year;

  }

  document.getElementById('changeDateVou').value
  if(document.getElementById('changeDateVou').value=="Previous Year"){
    document.getElementById('vou_start_date').value=prev_year_start_date;
    document.getElementById('vou_end_date').value=prev_year_end_date;
    document.getElementById('changeDateVou').value="Current Year"


  }else{
    document.getElementById('vou_start_date').value=cur_year_start_date;
    document.getElementById('vou_end_date').value=cur_year_end_date;
    document.getElementById('changeDateVou').value="Previous Year"

  }
  document.getElementById('vou_start_date').focus();
  
}




function todayDatesVou(){
 // downloadLock();
  var today_date= new Date();
  cur_month=today_date.getMonth()+1;

  if(cur_month<10){
    cur_month="0"+cur_month;
  }
  cur_year=today_date.getFullYear();

  today_date=today_date.getDate();

  if(today_date<10){
    today_date="0"+today_date;
  }


  display_date=today_date+"-"+cur_month+"-"+cur_year


  document.getElementById('todayDateVou').value
  if(document.getElementById('todayDateVou').value=="Today"){
    //document.getElementById('start_date').value=prev_year_start_date;
    document.getElementById('vou_end_date').value=display_date;
    document.getElementById('todayDateVou').value="Clear"


  }else{
    //document.getElementById('start_date').value=cur_year_start_date;
    document.getElementById('vou_end_date').value="";
    document.getElementById('todayDateVou').value="Today"

  }
  document.getElementById('vou_end_date').focus();
  
}


</script>


<style>
*
{
	margin:0;
	padding:0;
}

table,th,td
{
	border-collapse:collapse;
	font-size:12px;
}
</style>
<script type="text/javascript" src="../js/dateCheck.js"></script>
<?php include("../includes/jQDate.php"); ?>  

<?php 

$search_supplier_code="";
if(isset($_REQUEST['search_supplier_account_code'])){
  $search_supplier_code=$_REQUEST['search_supplier_account_code'];
}

$search_buyer_code="";
if(isset($_REQUEST['search_buyer_account_code'])){
  $search_buyer_code=$_REQUEST['search_buyer_account_code'];
}

$vou_start_date="";
if(isset($_REQUEST['vou_start_date'])){
  $vou_start_date=$_REQUEST['vou_start_date'];
}

$vou_end_date="";
if(isset($_REQUEST['vou_end_date'])){
  $vou_end_date=$_REQUEST['vou_end_date'];
}

$src_man_vou_num="";
if(isset($_REQUEST['src_man_vou_num'])){
  $src_man_vou_num=$_REQUEST['src_man_vou_num'];
}

$src_pay_ent_id="";
if(isset($_REQUEST['src_pay_ent_id'])){
  $src_pay_ent_id=$_REQUEST['src_pay_ent_id'];
}


$bill_report_disp="";
if(isset($_REQUEST['payment_report_disp'])){
  $bill_report_disp=$_REQUEST['payment_report_disp'];
}

$source="";
if(isset($_REQUEST['src'])){
  $source=$_REQUEST['src'];
}



$time=time()+19800; // Timestamp is in GMT now converted to IST
$date=date('d_m_Y_H_i_s',$time);

$month=date('n',$time);
$curr_year=date('Y',$time);
$next_year=$curr_year+1;
$prev_year=$curr_year-1;


if($month>3){
    $default_vou_start_date=$default_start_date="01-04-$curr_year";
    $default_vou_end_date=$default_end_date="31-03-$next_year";
    
    
}else{

    $default_vou_start_date=$default_start_date="01-04-$prev_year";
    $default_vou_end_date=$default_end_date="31-03-$curr_year";    
}


//echo $search_supplier_code;
?>
</head>

<body>
<table width="100%" border="5" align="center" style="border:1px solid #e5f1f8;background-color:#FFFFFF">
  <tr>
    <td><?php include("../includes/header.php"); ?></td>
  </tr>
  <tr>
    <td><?php include("../includes/menu.php"); ?></td>
  </tr>
  <tr>
    <td height="326" valign="top">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td valign="top">
            <div class="content_padding">
              <div class="content-header">
                <table width="100%" border='0'><tr>
                  <td width="25%" ><h3>Payment Search :</h3></td>
								<td align="center" width="30%">
                    				<?php
									if(isset($_SESSION['msg'])) {
                    					echo $_SESSION['msg'];
                    					$_SESSION['msg']='';
									}
									?>
								</td>								
								<td width="45%" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
            
            </tr></table>
              </div>
              <form method="post" id="payment_report" enctype="multipart/form-data" >              
              <table class="tbl_border">
                <tr>
                  <th  align="left"> Supplier Name </th>
                  <td>
                    <select name="search_supplier_account_code" id="search_supplier_account_code">
                        <option value="">All</option>
                          <?php
                            $s_sql="SELECT * FROM txt_company WHERE Firm_type='Supplier' AND delete_tag='FALSE' order by firm_name ASC";
                            $s_result=mysqli_query($con,$s_sql);
                            while($s_rs=mysqli_fetch_array($s_result))
                            {
                              $selected="";
                              if($search_supplier_code==$s_rs['company_id'])
                              {
                                $selected="selected";
                              }
                              echo "<option $selected value='".$s_rs['company_id']."'>".$s_rs['firm_name']."</option>";
                            }
                          ?>
                    </select>
		              </td>

                  <th align="left">Buyer Name</th>
			
                  <td>
                      <select name="search_buyer_account_code" id="search_buyer_account_code">
                          <option value="">All</option>
                            <?php
                              $s_sql="SELECT * FROM txt_company WHERE Firm_type='Buyer' AND delete_tag='FALSE' order by firm_name ASC";
                              $s_result=mysqli_query($con,$s_sql);
                              while($s_rs=mysqli_fetch_array($s_result))
                              {
                                $selected="";
                                if($search_buyer_code==$s_rs['company_id'])
                                {
                                  $selected="selected";
                                }
                                echo "<option $selected value='".$s_rs['company_id']."'>".$s_rs['firm_name']."</option>";
                              }
                            ?>
                      </select>
                  </td>
                </tr>
                <?php 
                  
                  $disp_start_date=$default_start_date;
                  $disp_end_date=$default_end_date;
                  $disp_vou_start_date=$default_vou_start_date;
                  $disp_vou_end_date=$default_vou_end_date;
                  if($bill_report_disp=="OK" || $source=="search"  ){ 
                    /*
                    $disp_start_date=$bill_start_date;
                    $disp_end_date=$bill_end_date;
                    */
                    $disp_vou_start_date=$vou_start_date;
                    $disp_vou_end_date=$vou_end_date;                    
                  }
                    
                ?>   

                <tr>
                  <th  align="left"> Payment Start Date .</th>
                  <td><input type="text"  onChange="validatedate_format(this)"  name="vou_start_date" class="datepick" size="8" id="vou_start_date" value="<?php echo $disp_vou_start_date ?>" /></td>

                  <th align="left">Payment End Date </th>
                  <td><input type="text"  onChange="validatedate_format(this)"  name="vou_end_date" class="datepick" size="8" id="vou_end_date" value="<?php echo $disp_vou_end_date ?>" />
                  &nbsp;&nbsp; <input  type="button" class="date-button" onclick="changeDatesVou()" name="changeDateVou" id="changeDateVou" value="Previous Year" />
                  &nbsp;&nbsp; <input  type="button" class="date-button" onclick="todayDatesVou()" name="todayDateVou" id="todayDateVou" value="Today" />
                </td>
                </tr>
                <tr>
                  <th  align="left"> Manual Voucher Number</th>
                  <td><input type="text" name="src_man_vou_num" size="8" id="src_man_vou_num" value="<?php echo $src_man_vou_num ?>" /></td>

                  <th align="left">Payment Entry Id </th>
                  <td><input type="text" name="src_pay_ent_id"  size="8" id="src_pay_ent_id" value="<?php echo $src_pay_ent_id ?>" /></td>
                </tr>                
                <tr><td colspan='4'> <span class="astrik">*</span> Report will be displayed in order of <b> Bill Date </b></td></tr>

                
              </table>
              <br>
              <table>
              <tr>
                <td>
                <input  type="button" class="form-button" onclick="payment_search_submit()" name="my_btn" value="Go" />
                </td></tr>
              </table>
              <input type='hidden' name='payment_report_disp' id='payment_report_disp' value='OK' >
              <br>
              <br>
              </form>
              <?php 
                if(isset($_REQUEST['payment_report_disp'])){
              if($_REQUEST['payment_report_disp']=='OK'){ ?>           
              <?php include("payment_search_display.php"); ?>   
              <?php } }?>           
            </div>                                 
          </td>
        </tr>
        <tr>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>

    </td>
  </tr>
    <?php include("../includes/footer.php"); ?>

</table>
</body>
</html>
<script>
    <?php if($_REQUEST['src']=="search"){
        echo "payment_search_submit();";

    }
    ?>
</script>
<?php 
release_connection($con);
?>
