<?php
    
    $this->form->open("AddADVTSurvey","index.php?option=com_mlm&task=survey_cont.addSurvey")
            ->setColumns(1)
            ->text("Survey Title","name='title' class='input req-string'")
    ->textArea("Suvey Link","name='survey' class='req-string' cols='50'")
    ->hidden("Option A","name='A' value='-'","N/A")
            ->hidden("Option B","name='B' value='-'","N/A")
            ->hidden("Option C","name='C' value='-'","N/A")
            ->hidden("Option D","name='D' value='-'","N/A")
            ->hidden("Correct","name='Correct' value='-'","N/A")
            ->text("Points For This Survey","name='Points' class='input req-string'")
            ->dateBox("Start Date","name='startdate' class='input req-string'")
            ->dateBox("End Date","name='enddate' class='input req-string'")
            ->hidden("Type","name='Type' value='ADVT'","Advertising View Ad")
            ->submit("Save Survey");
    echo $this->form->get();
?>