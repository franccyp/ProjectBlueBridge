<?php

 include "get_projects.php";

 class ProjectManagerTest{

    function test_get_projects_filter_name(){
        
        $manager = new ProjectManager();

        $manager->get_project_filter_name('Project BlueBridge');
    }

    function test_get_all_projects(){
        
        $manager = new ProjectManager();

        $manager->all_projects();
    }
 }

 $project_manager_test = new ProjectManagerTest();

 $project_manager_test->test_get_projects_filter_name();
  
 $project_manager_test->test_get_all_projects();
 
?>