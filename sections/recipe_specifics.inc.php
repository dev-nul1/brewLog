<?php mysql_select_db($database_brewing, $brewing);
$query_styles = sprintf("SELECT * FROM styles WHERE brewStyle='%s'", $row_log['brewStyle']);
$styles = mysql_query($query_styles, $brewing) or die(mysql_error());
$row_styles = mysql_fetch_assoc($styles);
$totalRows_styles = mysql_num_rows($styles);
?>
<div class="headerContent">Specifics</div>
<div class="dataContainer">
<table class="dataTable">
  <tr>
    <td width="100%">
	<table>
    	<tr>
  	   	   <td class="dataLabelLeft"><?php if (($page == "recipePrint") || ($page == "logPrint")) echo ""; else { ?><div id="help"><a href="sections/reference.inc.php?section=styles&source=log&KeepThis=true&TB_iframe=true&height=450&width=800" title="BJCP Style Reference" class="thickbox"><img src="<?php echo $imageSrc; ?>information.png" align="absmiddle" border="0" alt="Reference"></a></div><?php } ?>Style:</td>
		   <td class="data">
		   <?php if (($page ==  "recipePrint") || ($page == "logPrint")) echo $row_log['brewStyle']; else { ?><div id="moreInfo"><?php if ($totalRows_styles > 0) { ?><a href="#"><?php } echo $row_log['brewStyle'];  if ($totalRows_styles > 0) { ?><span><div id="moreInfoWrapper"><?php include ('reference/styles.inc.php'); ?></div></span></a>&nbsp;&nbsp;<a href="<?php echo $row_styles['brewStyleLink']; ?>" target="_blank"><img src="<?php echo $imageSrc; ?>link.png" align="absmiddle" border="0" alt="Click for more information about <?php echo $row_log['brewStyle']; ?> from the BJCP website." title="Click for more information about <?php echo $row_log['brewStyle']; ?> from the BJCP website."></a><?php } ?></div><?php } ?>		   </td>
       </tr>
	   <?php if ($row_pref['mode'] == "2") { 
	  	mysql_select_db($database_brewing, $brewing);
		$query_user2 = sprintf("SELECT * FROM users WHERE user_name = '%s'", $row_log['brewBrewerID']);
		$user2 = mysql_query($query_user2, $brewing) or die(mysql_error());
		$row_user2 = mysql_fetch_assoc($user2);
		$totalRows_user2 = mysql_num_rows($user2);
	    ?>
       <tr>
       	   <td class="dataLabelLeft"><?php if (($page =="recipeDetail") || ($page =="recipePrint")) echo "Contributor:"; else echo "Brewer:"; ?></td>
		   <td class="data"><?php if ($row_log['brewBrewerID'] == "") echo $row_name['brewerFirstName']."&nbsp;".$row_name['brewerLastName']; else echo $row_user2['realFirstName']."&nbsp;".$row_user2['realLastName']; ?></td>
       </tr>
	   <?php } ?>
<?php if (($page !="recipeDetail") && ($page !="recipePrint")) { ?>
  	   <tr>
       	   <td class="dataLabelLeft">Brew Date:</td>
		   <td class="data"><?php $date = $row_log['brewDate']; $realdate = dateconvert($date,2); echo $realdate; ?></td>
       </tr>
	   <?php if ($row_log['brewTapDate'] != "") { ?>
		<tr>
			<td class="dataLabelLeft">Tap Date:</td>
			<td class="data"><?php $date = $row_log['brewTapDate']; $realdate = dateconvert($date,2); echo $realdate; ?></td>
		</tr>
		<?php } // Tap Date ?>
<?php } ?>
	   <?php if ($row_log['brewYield'] != "" ) {  ?>
  	   <tr>
    	   <td class="dataLabelLeft">Yield:</td>
		   <td class="data"><?php if (($action == "default") || ($action == "print") || ($action == "reset")) echo $row_log['brewYield']; if ($action == "scale") echo $amt; echo "&nbsp;".$row_pref['measFluid2']; ?></td>
  	   </tr>
	   <?php } // Yield ?>
	   <?php if ($row_log['brewLovibond'] != "" ) {  ?>
  	   <tr>
  		   <td class="dataLabelLeft"><?php if (($page == "recipePrint") || ($page == "logPrint")) echo ""; else { ?><div id="help"><a href="sections/reference.inc.php?section=color&source=log&KeepThis=true&TB_iframe=true&height=350&width=600" title="SRM Color Reference" class="thickbox"><img src="<?php echo $imageSrc; ?>information.png" align="absmiddle" border="0" alt="Reference"></a></div><?php } ?>Color (<?php if ($row_pref['measColor'] == "EBC") echo "EBC"; else echo "SRM"; ?>/<?php if ($row_pref['measColor'] == "EBC") echo "SRM"; else echo "EBC"; ?>):</td>
		   <td class="data">
		   <?php
		   if (($page != "logPrint") && ($page != "recipePrint")) include (INCLUDES.'color_display.inc.php');
		   if (($page == "logPrint") || ($page == "recipePrint")) {
					if ($row_pref['measColor'] == "SRM") { echo round ($row_log['brewLovibond'], 1)."/"; echo colorconvert($row_log['brewLovibond'], "EBC"); }
					if ($row_pref['measColor'] == "EBC") { echo round ($row_log['brewLovibond'], 1)."/"; echo colorconvert($row_log['brewLovibond'], "SRM"); }
			}
		   ?>
           </td>
  	   </tr>
	   <?php } // Lovibond ?>
	   <?php if ($row_log['brewBitterness'] != "") {  ?>
  	   <tr>
  		   <td class="dataLabelLeft">Bitterness (Calc):</td>
		   <td class="data"><?php $IBU = ltrim ($row_log['brewBitterness'], "0"); echo round ($IBU,1)." ".$row_pref['measBitter']; if ($row_log['brewIBUFormula'] != "") echo " (".$row_log['brewIBUFormula'].")"; ?></td>
  	   </tr>
	   <?php } // Bitterness ?>
	   <?php if (($row_log['brewOG'] == "" ) || ($row_log['brewFG'] == "" )) echo ""; else { ?>
	   <?php if ($row_log['brewBitterness'] != "") { ?>
       <tr>
	     <td class="dataLabelLeft">BU/GU:</td>
	     <td class="data"><?php $bugu = $row_log['brewBitterness']/(($row_log['brewOG'] - 1) * 1000); echo round ($bugu, 2); ?></td>
	   </tr>
       <?php } ?>
	   <tr>
  	       <td class="dataLabelLeft">Calories:</td>
	       <td class="data"><?php echo round ($calories, 0); ?> (12 ounces)</td>
       </tr>
	   <?php } ?>
  <?php if (($page !="recipeDetail") && ($page !="recipePrint")) { ?>
	   <?php if ($row_log['brewCondition'] != "" ) {  ?>
  	   <tr>
  	   	   <td class="dataLabelLeft">Conditioning:</td>
		   <td class="data"><?php echo $row_log['brewCondition']; ?></td>
       </tr>
	   <?php } // Conditioning ?>
  <?php } ?>
	   <?php if (($row_log['brewOG'] == "" ) || ($row_log['brewFG'] == "" )) echo ""; else { ?>
  	   <tr>
  	       <td class="dataLabelLeft">ABV:</td>
	       <td class="data"><?php echo round ($abv, 1); ?>%</td>
  	   </tr>
  	   <tr>
  	       <td class="dataLabelLeft">ABW:</td>
	       <td class="data"><?php echo round ($abw, 1); ?>%</td>
       </tr>
	   <?php } // ABV, ABW ?>
   <?php if (($page !="recipeDetail") && ($page !="recipePrint")) { ?>
		<?php if (($row_log['brewOG'] == "" ) || ($row_log['brewFG'] == "" )) echo ""; else { ?>
  	   <tr>
  	   	   <td class="dataLabelLeft">
		   	   <?php 
		   	   if ($row_log['brewCondition'] == "Keg" ) "";
			   elseif ($row_log['brewCondition'] == "Cask" ) "";
			   elseif ($row_log['brewCondition'] == "Keg and Cask" ) "";
			   elseif ($row_log['brewCondition'] == "" ) "";
			   else echo "Bottling ABV:" 
			   ?>	       </td>
		   <td class="data">
		   	   <?php 
			   if ($row_log['brewCondition'] == "Bottles" ) echo round ($adj_abv, 1)."%";
			   elseif ($row_log['brewCondition'] == "Bottles and Keg" )  echo round ($adj_abv, 1)."%";
			   elseif ($row_log['brewCondition'] == "Bottles, Keg and Cask" )  echo round ($adj_abv, 1)."%";
			   else echo "" 
			   ?>		   </td>
  		</tr>
		<?php } // Bottling ABV ?>
   <?php } ?>	   
     </table>
	</td>
</div>