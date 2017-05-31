<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/8/16
 * Time: 5:59 AM
 */

//SN
echo "<td data-name= data-label=S.N align='left'>" . ($i + 1) . "</td>";
//Name
echo "<td data-name= data-label=Name align='left'><p class='text-info'>" . $participant_array[1] . "</p></td>";
//email
echo "<td data-name= data-label=Email align='left'>" . $participant_array[4] . "</td>";
//Address
echo "<td data-name= data-label=Address align='left'>" . $participant_array[3] . "</td>";
//Mobile
echo "<td data-name= data-label=Mobile align='center'>" . $participant_array[5] . "</td>";
//Participated As
if ($participant_array[2] == 0) {
	echo "<td data-name= data-label=Type align='center'>Participant</td>";
} else if ($participant_array[2] == 1) {
	echo "<td data-name= data-label=Type align='center'>Instructor</td>";
} else {
	echo "<td data-name= data-label=Type align='center'>Asst. Instructor</td>";
}

//Beneficiary Type
echo "<td data-name= data-label=Mobile align='center'>" . $participant_array[6] . "</td>";

echo "<td data-name= data-label=Mobile align='center'>" . $participant_array[7] . "</td>";

echo '<td data-name= data-label=View align="center">
    <a class= "text-success" href="../Person/viewPerson?id=' . $participant_array[0] . '">view</a>
    &nbsp; | &nbsp;
    <a class= "text-error handcursor" id="editparticipation_' . $participant_array[0] . '">edit</a>
    &nbsp; | &nbsp;
    <a class= "text-error handcursor" id="removecandidate_' . $participant_array[0] . '">unselect</a>
</td>';

?>