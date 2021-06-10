<?php

	session_start();
	include("../includes/dbconfig.php");

		if(isset($_POST['page']))
		{
			// echo "page set";

			if($_POST['page'] == 'giveExam')
			{
				if($_POST['action'] == 'load_question')
				{
					$output = '';
					$previous_id = '';
					$next_id='';

					$question_id = $_POST['question_id'];

					if($_POST['question_id'] == '' ){

						$question_id = 1;

						$examdata = $database->getReference("Exam/")
						->orderByChild("classcode")
						->equalTo($_POST['classcode'])
						->getvalue();

						foreach($examdata as $examtoken => $examkey){

							// echo $examkey['questionno']-1;
							
							if( strcmp($examkey['examtitle'],$_POST['examtitle']) == 0 ){
								

								$questionsdata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();

								foreach($questionsdata as $questoken => $queskey) {

									// // 1st question
									// echo "in foreach";
									// // var_dump($examkey);
									// var_dump ($examkey[1]["question"] );


									// var_dump($examkey);
									$output .= '
										<div class="top">
											<div class="ques">
												<h4> ques 1] '.$queskey[1]['question'].'</h4>
											</div>
										</div>
				
				
										<div class="center">
											
												<div class="question_left">
													<li style="padding-bottom:30px;"><input type="radio" name="option" >A].'.$queskey[1]["option 1"].'</li>
													<li style="padding-bottom:30px;"><input type="radio" name="option" >C].'.$queskey[1]["option 3"].'</li>
												</div>
												<div class="question_right">
													<li style="padding-bottom:30px;"><input type="radio" name="option" >B].'.$queskey[1]["option 2"].'</li>
													<li style="padding-bottom:30px;"><input type="radio" name="option" >D].'.$queskey[1]["option 4"].'</li>
												</div>
										
										</div>
										';	


								}

								if($question_id == ''){
									$previous_id = $examkey['questionno'];
								}
								elseif($question_id == 1){
									$previous_id = $examkey['questionno'];
								}
								else{
									$previous_id = $question_id+1;
								}

								// echo $previous_id;

								if($question_id == $examkey['questionno']){
									$next_id = 1;	
								}
								else{
									$next_id = $question_id + 1;
								}

								// echo $next_id;


							}

						}

					}
					else{
						
						
						$question_id = $_POST['question_id'];
						// echo 'question id = '. $question_id;

						$examdata = $database->getReference("Exam/")
						->orderByChild("classcode")
						->equalTo($_POST['classcode'])
						->getvalue();

						foreach($examdata as $examtoken => $examkey){

							
							
							if( strcmp($examkey['examtitle'],$_POST['examtitle']) == 0 ){
						

								$questionsdata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();

								foreach($questionsdata as $questoken => $queskey) {

									// question id is set

									// var_dump($queskey);	

									$output .= '
										<div class="top">
											<div class="ques">
												<h4> ques '.$question_id.'] '.$queskey[$question_id]['question'].'</h4>
											</div>
										</div>
				
				
										<div class="center">
											
												<div class="question_left">
													<li><input type="radio" name="option" >A].'.$queskey[$question_id]["option 1"].'</li>
													<li><input type="radio" name="option" >C].'.$queskey[$question_id]["option 3"].'</li>
												</div>
												<div class="question_right">
													<li><input type="radio" name="option" >B].'.$queskey[$question_id]["option 2"].'</li>
													<li><input type="radio" name="option" >D].'.$queskey[$question_id]["option 4"].'</li>
												</div>
										
										</div>
									</div>	
									';	
									


								}

								if($_POST['question_id'] == ''){
									$previous_id = $examkey['questionno'];
								}
								elseif($_POST['question_id'] == 1){
									$previous_id = $examkey['questionno'];
								}
								else{
									$previous_id = $question_id-1;
								}

								// echo $previous_id;

								if($_POST['question_id'] == $examkey['questionno']){
									$next_id = 1;	
								}
								else{
									$next_id = $question_id + 1;
								}

								// echo $next_id;


							}

						}


					}

					$if_previous_disable = '';
					$if_next_disable = '';

					if($previous_id == ""){
						$if_previous_disable = 'disabled';
					}
					
					if($next_id == ""){
						$if_next_disable = 'disabled';
					}

					$output .= '
					
						<div class="center2">
						<button type="button" name="previous" class="previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
						<button type="button" name="next" class="next" id="'.$next_id.'" '.$if_next_disable.'>Next</button>
					
					';


					echo $output;

				}

					
				
				if($_POST['action'] == 'question_navigation')
				{
					$output = '';

					$examdata = $database->getReference("Exam/")
					->orderByChild("classcode")
					->equalTo($_POST['classcode'])
					->getvalue();

					foreach($examdata as $examtoken => $examkey){
						
						if( strcmp($examkey['examtitle'],$_POST['examtitle']) == 0 ){

							$count = 1;
							while($count != $examkey['questionno']+1 ){

								$output .= '
								<button type="button" name="question_navigation" class="btn btn-primary btn-lg question_navigation" data-question_id="'.$count.'"  id="'.$count.'" >'.$count.'</button>
								';
								
								$count=$count+1;


							}

						}

					}

					echo $output;

				}

				
				if($_POST['action'] == 'answer')
				{
					
				}
			}
			
		}

?>