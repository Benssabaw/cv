<?php
$fullName = htmlspecialchars($_POST['fullName'] ?? 'Stevene Amiths');
$profession = htmlspecialchars($_POST['profession'] ?? 'IT Professional');
$email = htmlspecialchars($_POST['email'] ?? 'No email provided');
$phone = htmlspecialchars($_POST['phone'] ?? 'No phone provided');
$address = htmlspecialchars($_POST['address'] ?? 'No address provided');
$summary = htmlspecialchars($_POST['summary'] ?? '');

$skillsRaw = $_POST['skills'] ?? '';
$skillsArray = array_filter(array_map('trim', explode(',', $skillsRaw)));

$exp_title = htmlspecialchars($_POST['exp_title'] ?? '');
$exp_company = htmlspecialchars($_POST['exp_company'] ?? '');
$exp_duration = htmlspecialchars($_POST['exp_duration'] ?? '');
$exp_desc = htmlspecialchars($_POST['exp_desc'] ?? '');

$edu_degree = htmlspecialchars($_POST['edu_degree'] ?? '');
$edu_school = htmlspecialchars($_POST['edu_school'] ?? '');
$edu_year = htmlspecialchars($_POST['edu_year'] ?? '');

$profilePicPath = "default.png";
if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
    $uploadDir = __DIR__ . '/uploads/'; 
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileExtension = pathinfo($_FILES['profilePic']['name'], PATHINFO_EXTENSION);
    $newFileName = md5(time() . $fullName) . '.' . $fileExtension;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $destination)) {
        $profilePicPath = 'uploads/' . $newFileName;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $fullName ?> - Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-col: #1E293B;
            --accent: #3B82F6;
            --accent-light: #EFF6FF;
            --light-col: #FFFFFF;
            --text-dark: #334155;
            --text-muted: #64748B;
            --text-light: #F8FAFC;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #E2E8F0; display: flex; justify-content: center; padding: 40px 20px; font-family: 'Inter', sans-serif; }
        
        .resume-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: var(--light-col);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        .left-col { width: 35%; background: var(--dark-col); color: var(--text-light); padding: 50px 40px; }
        
        .profile-img-container { text-align: center; margin-bottom: 40px; }
        .profile-img { width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 4px solid var(--accent); padding: 6px; background: rgba(255,255,255,0.1); }
        
        .left-section-title { font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 2px solid rgba(59, 130, 246, 0.4); padding-bottom: 8px; margin: 35px 0 20px; color: var(--accent); font-weight: 700; }
        
        .contact-info p { margin-bottom: 18px; font-size: 0.95rem; line-height: 1.5; color: #E2E8F0; }
        .contact-info span { display: block; font-size: 0.75rem; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; font-weight: 600; }

        .skills-list { list-style: none; }
        .skills-list li { margin-bottom: 12px; font-size: 0.95rem; padding-left: 20px; position: relative; color: #E2E8F0; }
        .skills-list li::before { content: "▹"; color: var(--accent); position: absolute; left: 0; font-size: 1rem; top: 0px; font-weight: bold;}

        .right-col { width: 65%; padding: 60px 50px; position: relative; }
        
        .name-header { margin-bottom: 35px; }
        .name-header h1 { font-size: 3.5rem; font-weight: 800; color: var(--dark-col); line-height: 1.1; margin-bottom: 8px; letter-spacing: -1px;}
        .name-header h2 { font-size: 1.5rem; font-weight: 500; color: var(--accent); }

        .summary-text { font-size: 1.05rem; line-height: 1.7; color: var(--text-muted); margin-bottom: 45px; border-left: 4px solid var(--accent-light); padding-left: 15px;}

        .right-section-title { font-size: 1.5rem; font-weight: 700; color: var(--dark-col); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px; display: flex; align-items: center; }
        .right-section-title::after { content: ""; flex: 1; height: 2px; background: #E2E8F0; margin-left: 20px; }

        .timeline-item { margin-bottom: 35px; }
        .timeline-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px; }
        .timeline-title { font-size: 1.25rem; font-weight: 700; color: var(--dark-col); }
        .timeline-date { font-size: 0.85rem; font-weight: 600; color: var(--accent); background: var(--accent-light); padding: 6px 14px; border-radius: 20px; letter-spacing: 0.5px;}
        .timeline-subtitle { font-size: 1.05rem; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; }
        .timeline-desc { font-size: 1rem; line-height: 1.6; color: var(--text-main); }

        .btn-create { position: absolute; top: 30px; right: 40px; background: var(--accent-light); color: var(--accent); text-decoration: none; padding: 10px 20px; font-size: 0.85rem; font-weight: 700; border-radius: 6px; transition: 0.2s; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(59, 130, 246, 0.2);}
        .btn-create:hover { background: var(--accent); color: white; }

        @media (max-width: 850px) {
            .resume-wrapper { flex-direction: column; }
            .left-col, .right-col { width: 100%; padding: 40px 30px; }
            .btn-create { position: relative; top: 0; right: 0; display: inline-block; margin-bottom: 25px; }
            .name-header h1 { font-size: 2.8rem; }
        }
    </style>
</head>
<body>

    <div class="resume-wrapper">
        <div class="left-col">
            <div class="profile-img-container">
                <img src="<?= $profilePicPath ?>" alt="Profile Picture" class="profile-img">
            </div>

            <h3 class="left-section-title">Contact</h3>
            <div class="contact-info">
                <p><span>Email</span> <?= $email ?></p>
                <p><span>Phone</span> <?= $phone ?></p>
                <p><span>Location</span> <?= $address ?></p>
            </div>

            <h3 class="left-section-title">Expertise</h3>
            <ul class="skills-list">
                <?php foreach ($skillsArray as $skill): ?>
                    <li><?= htmlspecialchars($skill) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="right-col">
            <a href="index.html" class="btn-create">Create New CV</a>

            <div class="name-header">
                <h1><?= $fullName ?></h1>
                <h2><?= $profession ?></h2>
            </div>

            <p class="summary-text"><?= nl2br($summary) ?></p>

            <h3 class="right-section-title">Experience</h3>
            <div class="timeline-item">
                <div class="timeline-header">
                    <div class="timeline-title"><?= $exp_title ?></div>
                    <div class="timeline-date"><?= $exp_duration ?></div>
                </div>
                <div class="timeline-subtitle"><?= $exp_company ?></div>
                <div class="timeline-desc"><?= nl2br($exp_desc) ?></div>
            </div>

            <h3 class="right-section-title">Education</h3>
            <div class="timeline-item">
                <div class="timeline-header">
                    <div class="timeline-title"><?= $edu_degree ?></div>
                    <div class="timeline-date"><?= $edu_year ?></div>
                </div>
                <div class="timeline-subtitle"><?= $edu_school ?></div>
            </div>
        </div>
    </div>

</body>
</html>
