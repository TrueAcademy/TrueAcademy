<?php

	session_start();
	include("../includes/dbconfig.php");



	if(isset($_POST['page']))
	{
		// echo "page set";

		if($_POST['page'] == 'preExam' ){

			if($_POST['action'] == 'makeattendance' ){

				// echo "In action";
		
				$studentdata = $database->getReference("studentTable/")
				->orderByChild("email")
				->equalTo($_SESSION['email'])
				->getvalue();

				foreach($studentdata as $studenttoken => $studentkey){

					if($studentkey['email'] == $_SESSION['email'] ){

						$examassign = $database->getReference("studentTable/".$studenttoken."/assignedExam")->getvalue();

						foreach($examassign as $examassigntoken => $examassignkey){

							if($examassignkey['examtitle'] == $_POST['examtitle'] and $examassignkey['classcode'] == $_POST['classcode'] ){

								for($i = 1; $i<=10; $i++){
									$answersheet[$i] = "";
								}
										
								$update = [
									'attandance' => "attended",
								];
								$update1 = [
									'answersheet' => $answersheet,
									'marks' => 0,
									'totalcorrect' => 0
								];

								try{
									$database->getReference("studentTable/".$studenttoken."/assignedExam/".$examassigntoken)->update($update);
									$database->getReference("studentTable/".$studenttoken."/assignedExam/".$examassigntoken."/results")->update($update1);
								}
								catch(Exception $e){
										
								}
										
							}

						}    

					}

				}


			}
					


		}

	
		
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
						// echo 'question id = '. $question_id;

						$examdata = $database->getReference("Exam/")
						->orderByChild("classcode")
						->equalTo($_POST['classcode'])
						->getvalue();

						foreach($examdata as $examtoken => $examkey){

							// echo $examkey['questionno']-1;
							
							if( strcmp($examkey['examtitle'],$_POST['examtitle']) == 0 ){
								

								$questionsdata = $database->getReference("Exam/".$examtoken."/questions")->getvalue();

								foreach($questionsdata as $questoken => $queskey) {

								
									$output .= '
										<div class="top">
											<div class="ques">
												<h4> ques 1] '.$queskey[1]['question'].'</h4>
											</div>
										</div>
				
				
										<div class="center">
											
												<div class="question_left">
													<li style="padding-bottom:30px;"><input type="radio" name="option" class="answer_option" data-question_id="1" data-ans_id="'.$queskey[1]["option 1"].'" data-option_id="option_1" /><label id="option_1">A].'.$queskey[1]["option 1"].'</label></li>
													<li style="padding-bottom:30px;"><input type="radio" name="option" class="answer_option" data-question_id="1" data-ans_id="'.$queskey[1]["option 2"].'" data-option_id="option_2" /><label id="option_2">B].'.$queskey[1]["option 2"].'</label></li>
												</div>
												<div class="question_right">
													<li style="padding-bottom:30px;"><input type="radio" name="option" class="answer_option" data-question_id="1" data-ans_id="'.$queskey[1]["option 3"].'" data-option_id="option_3" /><label id="option_3">C].'.$queskey[1]["option 3"].'</label></li>
													<li style="padding-bottom:30px;"><input type="radio" name="option" class="answer_option" data-question_id="1" data-ans_id="'.$queskey[1]["option 4"].'" data-option_id="option_4" /><label id="option_4">D].'.$queskey[1]["option 4"].'</label></li>
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
													<li><input type="radio" name="option" class="answer_option" data-question_id="'.$question_id.'" data-ans_id="'.$queskey[$question_id]["option 1"].'" data-option_id="option_1" /><label id="option_1" >A].'.$queskey[$question_id]["option 1"].'</label></li>
													<li><input type="radio" name="option" class="answer_option" data-question_id="'.$question_id.'" data-ans_id="'.$queskey[$question_id]["option 2"].'" data-option_id="option_2" /><label id="option_2" >B].'.$queskey[$question_id]["option 2"].'</label></li>
												</div>
												<div class="question_right">
													<li><input type="radio" name="option" class="answer_option" data-question_id="'.$question_id.'" data-ans_id="'.$queskey[$question_id]["option 3"].'" data-option_id="option_3" /><label id="option_3" >C].'.$queskey[$question_id]["option 3"].'</label></li>
													<li><input type="radio" name="option" class="answer_option" data-question_id="'.$question_id.'" data-ans_id="'.$queskey[$question_id]["option 4"].'" data-option_id="option_4" /><label id="option_4" >D].'.$queskey[$question_id]["option 4"].'</label></li>
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

					
					$output .= '
					
						<div class="center2">
							<button type="button" name="previous" class="previous" id="'.$previous_id.'" >Previous</button>
							<button type="button" name="next" class="next" id="'.$next_id.'" >Next</button>
					';


				

					// <script>
					// 	document.getElementById($question_id).style.backgroundColor = 'Red'; 
					// </script>

				


					// var_dump($solvedques);
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
								<button type="button" name="question_navigation" class="btn-lg question_navigation" data-question_id="'.$count.'"  id="'.$count.'"  style="padding: 0px 10px; margin: 20px 0px; color: #fff; background-color: #7C4DFF; border-color: #007bff; border: 1px solid transparent; border-radius: 5px; display: flex; "  >'.$count.'</button>
								';
								
								$count=$count+1;


							}

						}

					}

					echo $output;


				}

				
				 
				if($_POST['action'] == 'answer')
				{
					$examtitle = $_POST['examtitle'];
					$classcode = $_POST['classcode'];
					$answer_option = $_POST['answer_option'];
					$question_id = $_POST['question_id'];
					$option_id = $_POST['option_id'];

					// $solvedques[$question_id] = $answer_option;
					// // $solvedques = array_push($solvedques,array($question_id => $answer_option));

					// print_r($solvedques);
					// // var_dump($solvedques);

					// echo "question id = ". $question_id;

					// var_dump("option selected = ". $answer_option);

					$studentData = $database->getReference("studentTable/")
					->orderByChild('email')
					->equalTo($_SESSION['email'])
					->getvalue();

					foreach($studentData as $studentToken => $studentKey){

						// var_dump($studentKey);

						if( strcmp($studentKey['email'],$_SESSION['email'] ) == 0 ){

								$examdata = $database->getReference("studentTable/".$studentToken."/assignedExam")->getvalue();

								foreach($examdata as $examtoken => $examkey){

									if(strcmp($examkey['examtitle'],$examtitle) == 0 and strcmp($examkey['classcode'],$classcode) == 0  ){

										
										$update = [
											$question_id => $answer_option
										];

										// var_dump($update);

										try{
											$database->getReference("studentTable/".$studentToken."/assignedExam/".$examtoken."/results/answersheet" )->update($update);
											echo "<script type='text/javascript'>document.getElementById(".$question_id.").style.backgroundColor='Red'; </script>";
											// echo "option id == ". $option_id;
											echo "<script type='text/javascript'>document.getElementById(".$option_id.").style.color='green'; </script>";
										}catch(Exception $e){
											// echo "error ";
										}

									}

								}

						

						}


					}

					
				}

				if($_POST['action'] == 'submitexam'){
					// echo "Exam Submitted!";

					$examtitle = $_POST['examtitle'];
					$classcode = $_POST['classcode'];

					$studentData = $database->getReference("studentTable")
					->orderByChild("email")
					->equalTo($_SESSION['email'])
					->getvalue();

					foreach($studentData as $studentToken => $studentKey){

						if(strcmp($studentKey['email'],$_SESSION['email']) == 0 ){

							$examdata = $database->getReference("studentTable/".$studentToken."/assignedExam")->getvalue();

							foreach($examdata as $examtoken => $examkey){

								if(strcmp($examkey['examtitle'],$examtitle) == 0 and strcmp($examkey['classcode'],$classcode) == 0  ){

									
									$quesdata = $database->getReference("Exam/")
									->orderByChild("classcode")
									->equalto($classcode)
									->getvalue();

									foreach($quesdata as $questoken => $queskey){

										if(strcmp($queskey['examtitle'],$examtitle) == 0 ){

											$answer = $database->getReference("Exam/".$questoken."/questions")->getvalue();

											foreach($answer as $answertoken => $answerkey){

												$answersheet = $database->getReference("studentTable/".$studentToken."/assignedExam/".$examtoken."/results/answersheet" )->getvalue();
												$totalcorrect = 0;

												for($question_id=1; $question_id<=10; $question_id++){



													// echo $answersheet[$question_id]
													if($answersheet[$question_id] == ''){

														$update = [
															$question_id => "Not Attended"
														];
														try{
															$database->getReference("studentTable/".$studentToken."/assignedExam/".$examtoken."/results/answersheet" )->update($update);
														}catch(Exception $e){

														}

													}elseif( strcmp( $answersheet[$question_id], $answerkey[$question_id]['answer'] ) == 0  ){

														$totalcorrect = $totalcorrect + 1;
													}

												}

												$update = [
													'marks' => $totalcorrect,
													'totalcorrect' => $totalcorrect
												];

												var_dump($update);

												try{
													$database->getReference("studentTable/".$studentToken."/assignedExam/".$examtoken."/results")->update($update);
													$update1 = [
														'resultcalculated' => 'true'
													];
													$database->getReference("studentTable/".$studenTabletoken."/assignedExam/".$studentexamtoken)->update($update);

												}catch(Exception $e){

												}


											}

											

										}

									}

									


								}


							}

						}

					}

				}


		}
			
	}

?>