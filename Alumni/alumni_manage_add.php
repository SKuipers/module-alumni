<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

@session_start() ;

//Module includes
include "./modules/" . $_SESSION[$guid]["module"] . "/moduleFunctions.php" ;

if (isActionAccessible($guid, $connection2, "/modules/Alumni/alumni_manage_add.php")==FALSE) {
	//Acess denied
	print "<div class='error'>" ;
		print __($guid, "You do not have access to this action.") ;
	print "</div>" ;
}
else {
	print "<div class='trail'>" ;
	print "<div class='trailHead'><a href='" . $_SESSION[$guid]["absoluteURL"] . "'>" . __($guid, "Home") . "</a> > <a href='" . $_SESSION[$guid]["absoluteURL"] . "/index.php?q=/modules/" . getModuleName($_GET["q"]) . "/" . getModuleEntry($_GET["q"], $connection2, $guid) . "'>" . __($guid, getModuleName($_GET["q"])) . "</a> > <a href='" . $_SESSION[$guid]["absoluteURL"] . "/index.php?q=/modules/Alumni/alumni_manage.php'>" . __($guid, 'Manage Alumni') . "</a> > </div><div class='trailEnd'>" . __($guid, 'Add') . "</div>" ;
	print "</div>" ;
	
	if (isset($_GET["addReturn"])) { $addReturn=$_GET["addReturn"] ; } else { $addReturn="" ; }
	$addReturnMessage="" ;
	$class="error" ;
	if (!($addReturn=="")) {
		if ($addReturn=="fail0") {
			$addReturnMessage=__($guid, "Your request failed because you do not have access to this action.") ;	
		}
		else if ($addReturn=="fail2") {
			$addReturnMessage=__($guid, "Your request failed due to a database error.") ;	
		}
		else if ($addReturn=="fail2a") {
			$addReturnMessage=__($guid, "Your optional extra data failed to save.") ;	
			$class="warning" ;
		}
		else if ($addReturn=="fail3") {
			$addReturnMessage=__($guid, "Your request failed because your inputs were invalid.") ;	
		}
		else if ($addReturn=="fail4") {
			$addReturnMessage=__($guid, "Your request failed because your inputs were invalid.") ;	
		}
		else if ($addReturn=="fail5") {
			$addReturnMessage=__($guid, "Your request was successful, but some data was not properly saved.") ;	
		}
		else if ($addReturn=="success0") {
			$addReturnMessage=__($guid, "Your request was completed successfully. You can now add another record if you wish.") ;	
			$class="success" ;
		}
		else if ($addReturn=="success1") {
			$addReturnMessage=__($guid, "Your request was completed successfully. You can now add extra information below if you wish.") ;	
			$class="success" ;
		}
		print "<div class='$class'>" ;
			print $addReturnMessage;
		print "</div>" ;
	} 
	
	$alumniAlumnusID=NULL ;
	if (isset($_GET["alumniAlumnusID"])) {
		$alumniAlumnusID=$_GET["alumniAlumnusID"] ;
	}
	
	print "<div class='linkTop'>" ;
		$policyLink=getSettingByScope($connection2, "Behaviour", "policyLink") ;
		if ($policyLink!="") {
			print "<a target='_blank' href='$policyLink'>" . __($guid, 'View Behaviour Policy') . "</a>" ;
		}
		if ($_GET["graduatingYear"]!="") {
			if ($policyLink!="") {
				print " | " ;
			}
			print "<a href='" . $_SESSION[$guid]["absoluteURL"] . "/index.php?q=/modules/Alumni/alumni_manage.php&graduatingYear=" . $_GET["graduatingYear"] . "'>" . __($guid, 'Back to Search Results') . "</a>" ;
		}
	print "</div>" ;
	?>

	<form method="post" action="<?php print $_SESSION[$guid]["absoluteURL"] . "/modules/" . $_SESSION[$guid]["module"] . "/alumni_manage_addProcess.php?graduatingYear=" . $_GET["graduatingYear"] ?>">
		<table class='smallIntBorder' cellspacing='0' style="width: 100%">	
			<tr class='break'>
				<th colspan=2> 
					<?php print __($guid, "Personal Details") ; ?>
				</td>
			</tr>
			<tr>
				<td style='width: 275px'> 
					<b><?php print __($guid, 'Title') ?></b><br/>
				</td>
				<td class="right">
					<select style="width: 302px" name="title">
						<option value=""></option>
						<option value="Ms."><?php print __($guid, 'Ms.') ?></option>
						<option value="Miss"><?php print __($guid, 'Miss') ?></option>
						<option value="Mr."><?php print __($guid, 'Mr.') ?></option>
						<option value="Mrs."><?php print __($guid, 'Mrs.') ?></option>
						<option value="Dr."><?php print __($guid, 'Dr.') ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'First Name') ?> *</b><br/>
				</td>
				<td class="right">
					<input name="firstName" id="firstName" maxlength=30 value="" type="text" style="width: 300px">
					<script type="text/javascript">
						var firstName=new LiveValidation('firstName');
						firstName.add(Validate.Presence);
					</script>
				</td>
			</tr>
			<tr>
				<td style='width: 275px'> 
					<b><?php print __($guid, 'Surname') ?> *</b><br/>
				</td>
				<td class="right">
					<input name="surname" id="surname" maxlength=30 value="" type="text" style="width: 300px">
					<script type="text/javascript">
						var surname=new LiveValidation('surname');
						surname.add(Validate.Presence);
					</script>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Official Name') ?></b><br/>
					<span style="font-size: 90%"><i><?php print __($guid, 'Full name as shown in ID documents.') ?></i></span>
				</td>
				<td class="right">
					<input name="officialName" id="officialName" maxlength=150 value="" type="text" style="width: 300px">
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Email') ?> *</b><br/>
				</td>
				<td class="right">
					<input name="email" id="email" maxlength=50 value="" type="text" style="width: 300px">
					<script type="text/javascript">
						var email=new LiveValidation('email');
						email.add(Validate.Email);
						email.add(Validate.Presence);
					</script>
				</td>
			</tr>
			
			<tr>
				<td> 
					<b><?php print __($guid, 'Gender') ?> *</b><br/>
				</td>
				<td class="right">
					<select name="gender" id="gender" style="width: 302px">
						<option value="Please select..."><?php print __($guid, 'Please select...') ?></option>
						<option value="F"><?php print __($guid, 'Female') ?></option>
						<option value="M"><?php print __($guid, 'Male') ?></option>
						<option value="F"><?php print __($guid, 'Other') ?></option>
						<option value="M"><?php print __($guid, 'Unspecified') ?></option>
					</select>
					<script type="text/javascript">
						var gender=new LiveValidation('gender');
						gender.add(Validate.Exclusion, { within: ['Please select...'], failureMessage: "<?php print __($guid, 'Select something!') ?>"});
					</script>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Main Role') ?> *</b><br/>
					<span style="font-size: 90%"><i><?php print __($guid, 'In what way, primarily, were you involved with the school?') ?></i></span>
				</td>
				<td class="right">
					<select name="formerRole" id="formerRole" style="width: 302px">
						<option value="Please select..."><?php print __($guid, 'Please select...') ?></option>
						<option value="Student"><?php print __($guid, 'Student') ?></option>
						<option value="Staff"><?php print __($guid, 'Staff') ?></option>
						<option value="Parent"><?php print __($guid, 'Parent') ?></option>
						<option value="Other"><?php print __($guid, 'Other') ?></option>
					</select>
					<script type="text/javascript">
						var formerRole=new LiveValidation('formerRole');
						formerRole.add(Validate.Exclusion, { within: ['Please select...'], failureMessage: "<?php print __($guid, 'Select something!') ?>"});
					</script>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Date of Birth') ?></b><br/>
					<span style="font-size: 90%"><i><?php print __($guid, 'Format:') . " " . $_SESSION[$guid]["i18n"]["dateFormat"]  ?></i></span>
				</td>
				<td class="right">
					<input name="dob" id="dob" maxlength=10 value="" type="text" style="width: 300px">
					<script type="text/javascript">
						$(function() {
							$( "#dob" ).datepicker();
						});
					</script>
				</td>
			</tr>
			
			<tr class='break'>
				<th colspan=2> 
					<?php print __($guid, "Tell Us More About Yourself") ; ?>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Maiden Name') ?></b><br/>
					<span style="font-size: 90%"><i><?php print __($guid, 'Your surname prior to marriage.') ?></i></span>
				</td>
				<td class="right">
					<input name="maidenName" id="maidenName" maxlength=30 value="" type="text" style="width: 300px">
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Username') ?></b><br/>
					<span style="font-size: 90%"><i><?php print __($guid, 'If you are young enough, this is how you logged into computers.') ?></i></span>
				</td>
				<td class="right">
					<input name="username2" id="username2" maxlength=20 value="" type="text" style="width: 300px">
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Graduating Year') ?></b><br/>
				</td>
				<td class="right">
					<select name="graduatingYear" id="graduatingYear" style="width: 302px">
						<?php
						print "<option value=''></option>" ;
						for ($i=date("Y"); $i>(date("Y")-200); $i--) {
							print "<option value='$i'>$i</option>" ;
						}
						?>				
					</select>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Current Country of Residence') ?></b><br/>
				</td>
				<td class="right">
					<select name="address1Country" id="address1Country" style="width: 302px">
						<?php
						print "<option value=''></option>" ;
						try {
							$dataSelect=array(); 
							$sqlSelect="SELECT printable_name FROM gibbonCountry ORDER BY printable_name" ;
							$resultSelect=$connection2->prepare($sqlSelect);
							$resultSelect->execute($dataSelect);
						}
						catch(PDOException $e) { }
						while ($rowSelect=$resultSelect->fetch()) {
							print "<option value='" . $rowSelect["printable_name"] . "'>" . htmlPrep(__($guid, $rowSelect["printable_name"])) . "</option>" ;
						}
						?>				
					</select>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Profession') ?></b><br/>
				</td>
				<td class="right">
					<input name="profession" id="profession" maxlength=30 value="" type="text" style="width: 300px">
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Employer') ?></b><br/>
				</td>
				<td class="right">
					<input name="employer" id="employer" maxlength=30 value="" type="text" style="width: 300px">
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Job Title') ?></b><br/>
				</td>
				<td class="right">
					<input name="jobTitle" id="jobTitle" maxlength=30 value="" type="text" style="width: 300px">
				</td>
			</tr>
			
			<tr class='break'>
				<th colspan=2> 
					<?php print __($guid, "Link To Gibbon User") ; ?>
				</td>
			</tr>
			<tr>
				<td> 
					<b><?php print __($guid, 'Existing User') ?></b><br/>
				</td>
				<td class="right">
					<select name="gibbonPersonID" id="gibbonPersonID" style="width: 302px">
						<?php
						print "<option value=''></option>" ;
						try {
							$dataSelect=array(); 
							$sqlSelect="SELECT gibbonPersonID, surname, preferredName, dob, username FROM gibbonPerson ORDER BY surname, preferredName" ;
							$resultSelect=$connection2->prepare($sqlSelect);
							$resultSelect->execute($dataSelect);
						}
						catch(PDOException $e) { print "error" . $e->getMessage() ; }
						while ($rowSelect=$resultSelect->fetch()) {
							print "<option value='" . $rowSelect["gibbonPersonID"] . "'>" . formatName("", $rowSelect["preferredName"], $rowSelect["surname"], "Student", TRUE) . " (" . $rowSelect["username"] ;
							if ($rowSelect["dob"]!="") {
								print  " | " . dateConvertBack($guid, $rowSelect["dob"]) ;
							}
							print ")</option>" ;
						}
						?>				
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					<span style="font-size: 90%"><i>* <?php print __($guid, "denotes a required field") ; ?></i></span>
				</td>
				<td class="right">
					<input type="hidden" name="address" value="<?php print $_SESSION[$guid]["address"] ?>">
					<input type="submit" value="<?php print __($guid, 'Submit') ?>">
				</td>
			</tr>
		</table>
	</form>
	<?php
}
?>