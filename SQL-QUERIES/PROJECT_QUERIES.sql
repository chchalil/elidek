--- ΕΡΩΤΗΣΗ 3.1.
SELECT projects.id, projects.title, projects.summery, projects.amount_of_fund, projects.duration, projects.start_date, projects.expiry_date, executives.name,executives.surname FROM projects
LEFT JOIN researcher_on_project as ronpr ON ronpr.project_id=projects.id
LEFT JOIN researchers as res ON ronpr.researcher_id = res.id
LEFT JOIN executive_to_project ON executive_to_project.project_id=projects.id
LEFT JOIN executives ON executive_to_project.executive_id = executives.id
         WHERE projects.start_date >= '' AND projects.expiry_date <= '' OR projects.duration = 1 OR  executives.id='' order by  projects.id asc

--- ΕΡΩΤΗΣΗ 3.2


SELECT r.id as res_id, r.name as res_name, r.surname as res_surname, p.id, p.title FROM researcher_on_project
INNER JOIN researchers r on researcher_on_project.researcher_id = r.id
INNER JOIN projects p on researcher_on_project.project_id=p.id
ORDER BY r.id asc



--- ΕΡΩΤΗΣΗ 3.2. ΔΕΥΤΕΡΗ

SELECT o.id as org_id, o.name as org_name, projects.id,projects.title FROM projects
INNER JOIN organizations o on projects.manager_organization_id = o.id
ORDER BY o.id asc









--- ΕΡΩΤΗΣΗ 3.3

SELECT asdf.description as description,p.id as project_id, p.title as project_title, researchers.id as res_id, researchers.name, researchers.surname FROM
(SELECT project_scientific_fields.scientific_field_id,scientific_fields.description, COUNT(project_scientific_fields.scientific_field_id) as count_sf
FROM project_scientific_fields
INNER JOIN projects ON projects.id = project_scientific_fields.project_id  AND start_date >='2022-06-05'
INNER JOIN scientific_fields ON scientific_fields.id = project_scientific_fields.scientific_field_id
GROUP BY  project_scientific_fields.scientific_field_id
ORDER BY count_sf DESC LIMIT 1) as asdf
INNER JOIN project_scientific_fields ON asdf.scientific_field_id=project_scientific_fields.scientific_field_id
INNER JOIN projects p on project_scientific_fields.project_id = p.id
INNER JOIN researcher_on_project rop on p.id = rop.project_id
INNER JOIN researchers on rop.researcher_id = researchers.id
GROUP BY researchers.id
ORDER BY p.id asc;


--- ΕΡΩΤΗΣΗ 3.5

SELECT  psf_sf.description,sf.description, COUNT(*) as count_zeygh
FROM
    projects
INNER JOIN project_scientific_fields  ON projects.id = project_scientific_fields.project_id
INNER JOIN project_scientific_fields psf ON projects.id = psf.project_id AND psf.scientific_field_id != project_scientific_fields.scientific_field_id
INNER JOIN scientific_fields psf_sf ON psf.scientific_field_id = psf_sf.id
INNER JOIN scientific_fields sf ON project_scientific_fields.scientific_field_id = sf.id
GROUP BY project_scientific_fields.scientific_field_id, psf.scientific_field_id
ORDER BY count_zeygh DESC


--- ΕΡΩΤΗΣΗ 3.6

    SELECT *, count(*) as count_r
    FROM
        researcher_on_project
    INNER JOIN projects ON researcher_on_project.project_id=projects.id AND projects.expiry_date >='2022-06-05'
    INNER JOIN researchers r on researcher_on_project.researcher_id = r.id AND r.date_of_birth <'1982-12-31'
    GROUP BY name, surname
    ORDER BY count_r desc



--- ΕΡΩΤΗΣΗ 3.7

SELECT ex.id, ex.name as resName, ex.surname , organizations.name, SUM(p.amount_of_fund) as funded FROM executive_to_project
INNER JOIN projects p on executive_to_project.project_id = p.id
INNER JOIN executives ex on executive_to_project.executive_id = ex.id
INNER JOIN organizations on p.manager_organization_id = organizations.id
GROUP BY ex.id, organizations.id
ORDER BY funded desc LIMIT 5


--- ΕΡΩΤΗΣΗ 3.8

SELECT researchers.id,researchers.name, researchers.surname, COUNT(*) as count_ndp FROM
(SELECT projects.id FROM projects
LEFT JOIN deliverables d on projects.id = d.project_id
WHERE d.id is NULL) as ndp
INNER JOIN researcher_on_project rop ON rop.project_id=ndp.id
INNER JOIN researchers ON rop.researcher_id = researchers.id
GROUP BY researchers.id
HAVING count_ndp >= 5
ORDER BY count_ndp desc



--- ΕΡΩΤΗΣΗ 3.4.


SELECT projects.id,manager_organization_id,YEAR(start_date) AS  year, count(*) FROM projects GROUP BY manager_organization_id order by manager_organization_id desc

SELECT *, count(manager_organization_id) as ergo FROM projects
INNER JOIN organizations o on projects.manager_organization_id = o.id
WHERE start_date >='2021-01-01' AND start_date <='2021-12-31'  GROUP BY manager_organization_id  ORDER BY ergo desc
