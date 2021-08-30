select * from trlitigation.dockets

select a.docketnumber, a.title, a.courtname, a.jurisdictionstate, a.filingdate, a.lastupdateddate, 
stuff((select '| ' + b.casetype
from trlitigation.dockets_casetype b
where a.jkey4 = b.jkey4
for xml path(''), root('MyString'), type
).value('/MyString[1]','varchar(max)'), 
1, 1, '') as casetypes,
stuff((select '| ' + c.name + ';' + c.title
from trlitigation.dockets_judges c
where a.jkey4 = c.jkey4
for xml path(''), root('MyString'), type
).value('/MyString[1]','varchar(max)'), 
1, 1, '') as judges,
stuff((select '| ' + d.name + ';' + d.role
from trlitigation.dockets_participants d
where a.jkey4 = d.jkey4
for xml path(''), root('MyString'), type
).value('/MyString[1]','varchar(max)'), 
1, 1, '') as participants,
stuff((select '| ' + f.name + ';' + f.title
from trlitigation.dockets_participants e
join trlitigation.dockets_participants_attorneys f on e.jkey4 = f.jkey4 and e.jkey6 = f.jkey6
join trlitigation.dockets_participants_attorneys_lawfirm g on f.jkey4 = g.jkey4 and f.jkey6 = g.jkey6 and f.jkey8 = g.jkey8
where a.jkey4 = e.jkey4
and g.mainname = 'Morgan, Lewis & Bockius LLP'
for xml path(''), root('MyString'), type
).value('/MyString[1]','varchar(max)'), 
1, 1, '') as attorneys --into DataReconciliation_docketdataset
from trlitigation.dockets a 
--join trlitigation.dockets_casetype b on a.jkey4 = b.jkey4
--where a.docketnumber = '0:20-CV-62530'

select * from datareconciliation_docketdataset
order by len(attorneys) desc

 Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner| Jonathan M. Albano;Partner


create table DataReconciliation_matterdataset_recordpertimeentry
(
   docketnumber nvarchar(250),
   matterid nvarchar(250),
   matterdescription nvarchar(1000),
   docketdescription nvarchar(1000),
   client nvarchar(250),
   areaoflaw nvarchar(100),
   opendate datetime,
   lastupdatedate datetime,
   timeentrydate datetime,
   timeentryattorney nvarchar(250),
   timenarrative nvarchar(1000),
   timeentryattorneyall nvarchar(max)
)

select * from datareconciliation_matterdataset_recordpertimeentry


insert into DataReconciliation_matterdataset_recordpertimeentry
values('202156', '0002345-00005', 'other text + Democratic National Committee + other text', 'peden, democratic committee', 'democratic committee', 
'Antitrust Counseling', '12/7/2020', '12/29/2020', '12/7/2020', 'Jonathan Albano', 'prep for filing of motion by mid December', 'Jonathan Albano|Clarise Stanton')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('202156', '0002345-00005', 'other text + Democratic National Committee + other text', 'peden, democratic committee', 'democratic committee', 
'Antitrust Counseling', '12/7/2020', '12/29/2020', '12/8/2020', 'Clarise Stanton', 'review materials', 'Jonathan Albano|Clarise Stanton')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('202156', '0003456-00012', 'other text + Virginia Democratic Comittee + other text', 'sampson vs. virginia democratic committee', 'virgina democratic committee', 
'PUBLIC SECTOR', '12/7/2019', '4/5/2020', '3/7/2020', 'Jim Barnborough', 'review materials', 'Jim Barnborough')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('2:20CV5171', '0004567-00015', 'Purdue vs. Clearfield County', 'Clearfield vs. Purdue', 'Purdue Pharmaceuticals', 
'Health Care', '10/2/2020', '10/19/2020', '10/5/2020', 'Harvey J. Bartle', 'review materials', 'Harvey J. Bartle|Maureen Barber|Elisa P McEnroe')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('2:20CV5171', '0004567-00015', 'Purdue vs. Clearfield County', 'Clearfield vs. Purdue', 'Purdue Pharmaceuticals', 
'Health Care', '10/2/2020', '10/19/2020', '10/6/2020', 'Maureen K. Barber', 'review materials', 'Harvey J. Bartle|Maureen Barber|Elisa P McEnroe')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('2:20CV5171', '0004567-00015', 'Purdue vs. Clearfield County', 'Clearfield vs. Purdue', 'Purdue Pharmaceuticals', 
'Health Care', '10/2/2020', '10/19/2020', '10/18/2020', 'Elisa P McEnroe', 'prepare to file motion', 'Harvey J. Bartle|Maureen Barber|Elisa P McEnroe')

insert into DataReconciliation_matterdataset_recordpertimeentry
values('220-CV05171', '0004567-00015', 'General Meds class action', 'Clawfourd vs. General Meds', 'General Meds', 
'Health Care', '10/5/2020', '12/4/2020', '10/15/2020', 'Megan Koch', 'prepare to file motion', 'Harvey J. Bartle|Megan Koch')

 Maureen K. Barber;Associate|
  Harvey Bartle IV.;Partner|
  Jacqueline C. Gorbey;Associate| 
  Elisa P. McEnroe;Partner| 
  Coleen M. Meehan;Partner| 
  Marisel Acosta;Associate| 
  Kelly A. Moore;Partner


   matterID
description
areaoflaw
clientsort (client name)
opendate
lastupdatedate
time entry dates
attorneys on time entries
time narratives
qcasenumber (docket id)


select a.docketnumber, a.title, a.courtname, a.jurisdictionstate, a.filingdate, a.lastupdateddate, 
b.casetype, c.name, c.title, d.name, d.role, e.name, e.title, f.mainname
from trlitigation.dockets a
left outer join trlitigation.dockets_casetype b on a.jkey4 = b.jkey4
left outer join trlitigation.dockets_judges c on a.jkey4 = c.jkey4
left outer join trlitigation.dockets_participants d on a.jkey4 = d.jkey4
left outer join trlitigation.dockets_participants_attorneys e on d.jkey4 = e.jkey4 and d.jkey6 = e.jkey6
left outer join trlitigation.dockets_participants_attorneys_lawfirm f on e.jkey4 = f.jkey4 and e.jkey6 = f.jkey6 and e.jkey8 = f.jkey8 and f.mainname = 'Morgan, Lewis & Bockius LLP'
order by docketnumber

select a.docketnumber, a.title, b.name, c.name, d.mainname
from trlitigation.dockets a
join trlitigation.dockets_participants b on a.jkey4 = b.jkey4
join trlitigation.dockets_participants_attorneys c on b.jkey4 = c.jkey4 and b.jkey6 = c.jkey6
join trlitigation.dockets_participants_attorneys_lawfirm d on c.jkey4 = d.jkey4 and c.jkey6 = d.jkey6 and c.jkey8 = d.jkey8
where docketnumber = '20-90051'
order by 

select * from trlitigation.dockets_participants where jkey4 = 0 order by convert(int, jkey4), convert(int, jkey6)

select * from trlitigation.dockets_participants_attorneys_lawfirm

select jkey4, count(*) from trlitigation.dockets_casetype
group by jkey4 having count(*) > 1

select * from TRLitigation_Matter_Prolaw

matterID
description
areaoflaw
clientsort (client name)
opendate
lastupdatedate
time entry dates
attorneys on time entries
time narratives
qcasenumber (docket id)