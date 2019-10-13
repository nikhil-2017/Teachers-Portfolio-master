       <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM assign_group";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){

                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Group_id</th>";
                                        echo "<th>Project Name</th>";
                                        echo "<th>Module Name</th>";
                                        echo "<th>Leader ID</th>";
										echo "<th>Emp_ID2</th>";
										echo "<th>Emp_ID3</th>";
										echo "<th>Emp_ID4</th>";
										echo "<th>Emp_ID5</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['group_id'] . "</td>";
                                        echo "<td>" . $row['project_name'] . "</td>";
                                        echo "<td>" . $row['module_name'] . "</td>";
                                        echo "<td>" . $row['emp_id1'] . "</td>";
                                        echo "<td>" . $row['emp_id2'] . "</td>";
                                        echo "<td>" . $row['emp_id3'] . "</td>";
										echo "<td>" . $row['emp_id4'] . "</td>";
										echo "<td>" . $row['emp_id5'] . "</td>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    ?>