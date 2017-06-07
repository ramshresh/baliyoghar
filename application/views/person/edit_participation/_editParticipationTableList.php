<table class="dataListing" width="700px" cellspacing="0" cellpadding="5" border="0">
    <tbody>
    <tr>
        <th width="5%" align="center">#</th>
        <th width="30%" align="left">Event</th>
        <th width="15%" align="left">Role</th>
        <th width="15%" align="left">Beneficiary Type</th>
        <th width="15%" align="left">Certification Status</th>
        <th width="7%" align="left">year</th>
        <th width="10%" align="left">Start date</th>
        <th width="10%" align="left">End date</th>
        <th width="23%" align="left">Venue</th>
        <th width="23%" align="left">Action</th>
        <?php
        if (isset($action) && $action !== null) {
            echo '<th style="width:60px" align="left">Action</th>';
        }
        ?>
    </tr>

    <?php
    for ($i = 0; $i < count($participations); $i++) {
        $_editParticipationRow_viewData['participation']=$participations[$i];
        $_editParticipationRow_viewData['i']=$i;

        echo "<tr id='event_row_" . $participations[$i][9] . "'>";
        $this->load->view('person/edit_participation/_editParticipationRow',$_editParticipationRow_viewData);
        echo '</tr>';
    }
    ?>

    </tbody>
</table>