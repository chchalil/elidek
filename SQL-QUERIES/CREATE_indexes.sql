

create index organization_id
    on organization_phone_number (organization_id);


create index executive_id
    on executive_to_project (executive_id);


create index researcher_id
    on project_assessment (researcher_id);


create index researcher_id
    on researcher_on_project (researcher_id);

create index organization_works_id
    on researchers (organization_works_id);


create index project_id
    on project_scientific_fields (project_id);

create index scientific_field_id
    on project_scientific_fields (scientific_field_id);

