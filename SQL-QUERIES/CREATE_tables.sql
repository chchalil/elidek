create table categories_of_organisations
(
    id          int auto_increment
        primary key,
    name        varchar(255) not null,
    budget_type varchar(50)  not null comment '1 = Υπουργείο Παιδείας,
2 = Ιδιωτικές Δράσεις,
3 = Ίδια Κεφάλαια
'
);

create table executives
(
    id                        int auto_increment
        primary key,
    name                      varchar(255) not null,
    surname                   varchar(255) not null,
    tax_identification_number varchar(255) not null,
    constraint tax_identification_number
        unique (tax_identification_number)
);

create table organizations
(
    id            int auto_increment
        primary key,
    name          varchar(255) not null,
    abbrevation   varchar(15)  not null,
    city          varchar(255) not null,
    street_name   varchar(255) not null,
    street_number varchar(255) not null,
    postal_code   int(5)       not null,
    category_id   int          not null,
    constraint organizations_ibfk_1
        foreign key (category_id) references categories_of_organisations (id)
);

create table organization_phone_number
(
    id              int auto_increment
        primary key,
    organization_id int         not null,
    number          varchar(15) not null,
    constraint number
        unique (number),
    constraint organization_phone_number_organizations_id_fk
        foreign key (organization_id) references organizations (id)
            on delete cascade
);

create table programmes
(
    id                  int auto_increment
        primary key,
    name                varchar(255) not null,
    name_of_directorate varchar(255) not null
);

create table researchers
(
    id                    int auto_increment
        primary key,
    name                  varchar(255) not null,
    surname               varchar(15)  not null,
    sex                   tinyint      not null,
    date_of_birth         date         null,
    start_date_work       date         null,
    organization_works_id int          not null,
    constraint researchers_ibfk_1
        foreign key (organization_works_id) references organizations (id)
);

create table projects
(
    id                        int auto_increment
        primary key,
    title                     varchar(255)   not null,
    summery                   varchar(255)   null,
    amount_of_fund            decimal(10, 4) not null,
    duration                  int(1)         not null,
    start_date                date           not null,
    expiry_date               date           not null,
    responsible_researcher_id int            not null,
    manager_organization_id   int            not null,
    funding_programme_id      int            not null,
    constraint projects_ibfk_1
        foreign key (responsible_researcher_id) references researchers (id)
            on update cascade,
    constraint projects_ibfk_2
        foreign key (manager_organization_id) references organizations (id)
            on update cascade,
    constraint projects_ibfk_3
        foreign key (funding_programme_id) references programmes (id)
            on update cascade,
    constraint amount_of_fund
        check (`amount_of_fund` between 100000 and 100000000),
    constraint duration
        check (`duration` between 1 and 4)
);

create table deliverables
(
    id               int auto_increment
        primary key,
    project_id       int          not null,
    title            varchar(255) not null,
    summery          varchar(255) not null,
    date_of_delivery date         null,
    constraint deliverables_ibfk_1
        foreign key (project_id) references projects (id)
            on update cascade on delete cascade
);

create table executive_to_project
(
    id           int auto_increment
        primary key,
    executive_id int not null,
    project_id   int not null,
    constraint project_id
        unique (project_id),
    constraint executive_to_project_ibfk_1
        foreign key (executive_id) references executives (id)
            on delete cascade,
    constraint executive_to_project_ibfk_2
        foreign key (project_id) references projects (id)
            on delete cascade
);

create table project_assessment
(
    id            int auto_increment
        primary key,
    project_id    int                                not null,
    researcher_id int                                not null,
    grade         int(3) default 0                   not null,
    date          date   default current_timestamp() not null,
    constraint project_id
        unique (project_id),
    constraint project_assessment_ibfk_1
        foreign key (project_id) references projects (id)
            on delete cascade,
    constraint project_assessment_ibfk_2
        foreign key (researcher_id) references researchers (id)
            on delete cascade
);

create table researcher_on_project
(
    id            int auto_increment
        primary key,
    project_id    int not null,
    researcher_id int not null,
    constraint researcher_on_project_ibfk_2
        foreign key (researcher_id) references researchers (id)
            on delete cascade,
    constraint researcher_on_project_projects_id_fk
        foreign key (project_id) references projects (id)
            on delete cascade
);


create table scientific_fields
(
    id          int auto_increment
        primary key,
    description varchar(255) not null
);

create table project_scientific_fields
(
    id                  int auto_increment
        primary key,
    project_id          int not null,
    scientific_field_id int not null,
    constraint project_scientific_fields_ibfk_1
        foreign key (project_id) references projects (id)
            on delete cascade,
    constraint project_scientific_fields_ibfk_2
        foreign key (scientific_field_id) references scientific_fields (id)
            on delete cascade
);