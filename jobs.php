<?php 

require 'app/Models/Job.php';
require 'app/Models/Project.php';


$job1 = new Job('PHP Developer', 'Durante algo más de dos años llevo trabajando con PHP');
$job1->setMonths(24);

$job2 = new Job('Laravel Developer', 'Durante algo más de dos años llevo trabajando con Laravel');
$job2->setMonths(20);

$job3 = new Job('.NET Developer', 'Especializando en el desarrollo de aplicaciones en .Net enfocadas a entornos de escritorio');
$job3->setMonths(12);


$project1 = new Project('Project1', 'Description1');
$jobs = [
    $job1,
    $job2,
    $job3
];

$projects = [
    $project1
];

  
/**
 * 
 */


/**
 * Undocumented function
 *
 * @param [type] $job
 * @return void
 */
function printElement($job)
{

    if ($job->getVisible() == false) {
        return;
    }
    echo '<li class="work-position">';
    echo '  <h5>' . $job->getTitle() . '</h5>';
    echo '  <p>' . $job->getDescription() . '</p>';
    echo '  <p>' . $job->getDurationAsString() . '</p>';
    echo '  <strong>Achievements:</strong>';
    echo '    <ul>';
    echo '      <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit. </li>';
    echo '      <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit. </li>';
    echo '      <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit. </li>';
    echo '    </ul>';
    echo '  </li>';
}