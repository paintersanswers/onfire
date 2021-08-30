select top 10 *
from finance.client
where open_date < '1/1/2017'
order by open_date desc

select * from people.people
where fullname like '%maryln%'

create table matter.closingbook
(
   id int identity(1,1),
   matter_name nvarchar(250),
   matter_number nvarchar(25),
   document_description nvarchar(1000),
   document_name nvarchar(250),
   document_link nvarchar(250)
)

alter table bd.client_recently_opened_matters
alter column matter_number nvarchar(20)


truncate table matter.closingbook


insert into matter.closingbook
values('Merger with Xilch Corp.', '000076.000019', 'Description 1', 'Doc Name 1', '<a href="onfiredoc.html" target="_blank">Document 1 Link</a>'),
('Merger with Xilch Corp.', '000076.000019', 'Description 2', 'Doc Name 2', '<a href="onfiredoc.html" target="_blank">Document 2 Link</a>'),
('Merger with Xilch Corp.', '000076.000019', 'Description 3', 'Doc Name 3', '<a href="onfiredoc.html" target="_blank">Document 3 Link</a>'),
('Merger with Xilch Corp.', '000076.000019', 'Description 4', 'Doc Name 4', '<a href="onfiredoc.html" target="_blank">Document 4 Link</a>')


select * from matter.closingbook

exec matter.getclosingbook '000076.000019'


create procedure matter.getclosingbook 
@matter_number nvarchar(25)
as

select matter_name, matter_number, document_description, document_name, document_link
from matter.closingbook
where matter_number = @matter_number
order by document_description


select * from onfire.questionanswer order by id desc

select * from onfire.questionanswercolumns
where questionanswerid = 23 

select * from onfire.questionanswerinformation


insert into onfire.questionanswer
values(null, 'Closing Book for Matter Merger with Xilch Corp. 000076.000019', 3, null, 'exec matter.getclosingbook ''000076.000019''', 5, 1, null, getdate(), getdate(), 61, 61)

insert into onfire.questionanswercolumns
values(25, 'matter_name', 'Matter Name', 1),
(25, 'matter_number', 'Matter Number', 2),
(25, 'document_description', 'Document Description', 3),
(25, 'document_name', 'Document Name', 4),
(25, 'document_link', 'Link', 5),
(25, 'matter_open_date', 'Matter Open Date', 6),
(23, 'billable_input', 'Billable Input', 7),
(23, 'partnersincharge', 'Partners In Charge', 8)

insert into onfire.questionanswerinformation
values(25, 'Closing Book documents for this matter. This information comes from the Firm closing book system and is updated hourly. Links open documents from the firm document system', getdate())








   