exec trlitigation.search 'silv'

alter procedure trlitigation.search
@string nvarchar(500)
as

select a.jkey4, a.docketnumber, a.title, a.filingdate, b.name
from trlitigation.dockets_stage a
join trlitigation.dockets_judges_stage b on a.jkey4 = b.jkey4
where b.name like '%' + ltrim(rtrim(@string)) + '%'
union
select a.jkey4, a.docketnumber, a.title, a.filingdate, b.name
from trlitigation.dockets_stage a
join trlitigation.dockets_judges_stage b on a.jkey4 = b.jkey4
where a.title like '%' + ltrim(rtrim(@string)) + '%'
union
select a.jkey4, a.docketnumber, a.title, a.filingdate, b.name
from trlitigation.dockets_stage a
join trlitigation.dockets_judges_stage b on a.jkey4 = b.jkey4
where a.docketnumber like '%' + ltrim(rtrim(@string)) + '%'
order by filingdate desc

go

exec trlitigation.getDocketInfo 30

alter procedure trlitigation.getDocketInfo
@jkey4 int
as

select distinct docketnumber, title, classaction, courttype, federalflag, 
casetypes = stuff((select ' | ' + casetype  from trlitigation.dockets_casetype_stage c where b.jkey4 = c.jkey4 for xml path (''), root('MyString'), type).value('/MyString[1]','varchar(max)'), 1, 3, ''),
filingdate, link, jurisdictionstate, lastupdateddate, '$' + convert(varchar, convert(money, totalawardeddamagesamount), 1) totalawardeddamagesamount
from trlitigation.dockets_stage a
left outer join trlitigation.dockets_casetype_stage b on a.jkey4 = b.jkey4
where a.jkey4 = @jkey4

alter procedure trlitigation.getdocketjudgeinfo
@jkey4 int
as

select name, title
from trlitigation.dockets_judges_stage
where jkey4 = @jkey4
order by name

exec trlitigation.getdocketawardeddamagesinfo 503

alter procedure trlitigation.getdocketawardeddamagesinfo
@jkey4 int
as

select '$' + convert(varchar, convert(money, a.amount), 1) amount, b.type
from trlitigation.dockets_awardeddamages_stage a
left outer join trlitigation.dockets_awardeddamages_type_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
where a.jkey4 = @jkey4


alter procedure trlitigation.getdocketmotionsinfo
@jkey4 int
as

select a.jkey4, a.jkey6, a.title, a.court, a.decision, a.filingdate, a.decisiondate, a.timetorule, b.motiontype
from trlitigation.dockets_motions_stage a
left outer join trlitigation.dockets_motions_motiontype_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
where a.jkey4 = @jkey4
order by filingdate desc

select * from trlitigation.dockets_motions_motiontype_stage
select * from trlitigation.dockets_motions_motiontype_motiontype_stage

alter procedure trlitigation.getdocketmotionsviewinfo
@jkey4 int, @jkey6 int
as

select distinct a.title, a.docketnumber, a.court, a.decision, a.filingdate, a.decisiondate, a.timetorule, b.motiontype,
casetypes = stuff((select ' | ' + casetype  from trlitigation.dockets_motions_casetype_stage d where c.jkey4 = d.jkey4 and c.jkey6 = d.jkey6 for xml path (''), root('MyString'), type).value('/MyString[1]','varchar(max)'), 1, 3, ''),
motiontypes2 = stuff((select ' | ' + motiontype  from trlitigation.dockets_motions_motiontype_motiontype_stage f where e.jkey4 = f.jkey4 and e.jkey6 = f.jkey6 and e.jkey8 = f.jkey8  for xml path (''), root('MyString'), type).value('/MyString[1]','varchar(max)'), 1, 3, '')
from trlitigation.dockets_motions_stage a
left outer join trlitigation.dockets_motions_motiontype_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
left outer join trlitigation.dockets_motions_casetype_stage c on a.jkey4 = c.jkey4 and a.jkey6 = c.jkey6
left outer join trlitigation.dockets_motions_motiontype_motiontype_stage e on b.jkey4 = e.jkey4 and b.jkey6 = e.jkey6 and b.jkey8 = e.jkey8
where a.jkey4 = @jkey4
and a.jkey6 = @jkey6



create procedure trlitigation.getdocketmotionsdecidingjudgeinfo
@jkey4 int, @jkey6 int
as

select name, title
from trlitigation.dockets_motions_decidingjudges_stage
where jkey4 = @jkey4
and jkey6 = @jkey6
order by name

create procedure trlitigation.getdocketmotionsjudgeinfo
@jkey4 int, @jkey6 int
as

select name, title
from trlitigation.dockets_motions_judges_stage
where jkey4 = @jkey4
and jkey6 = @jkey6
order by name



alter procedure trlitigation.getdocketoutcomesinfo
@jkey4 int
as

select outcometype, outcomedate, timetooutcome,
label1 = stuff((select ' | ' + label  from trlitigation.dockets_outcomes_label_stage c where b.jkey4 = c.jkey4 and b.jkey6 = c.jkey6 for xml path (''), root('MyString'), type).value('/MyString[1]','varchar(max)'), 1, 3, ''),
label2 = stuff((select ' | ' + label  from trlitigation.dockets_outcomes_label_label_stage e where d.jkey4 = e.jkey4 and d.jkey6 = e.jkey6 and d.jkey8 = e.jkey8 for xml path (''), root('MyString'), type).value('/MyString[1]','varchar(max)'), 1, 3, '')
from trlitigation.dockets_outcomes_stage a
left outer join trlitigation.dockets_outcomes_label_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
left outer join trlitigation.dockets_outcomes_label_label_stage d on b.jkey4 = d.jkey4 and b.jkey6 = d.jkey6 and b.jkey8 = d.jkey8
where a.jkey4 = @jkey4
order by outcomedate desc



select * from trlitigation.dockets_outcomes_stage
select * from trlitigation.dockets_outcomes_label_stage
select * from trlitigation.dockets_outcomes_label_label_stage


alter procedure trlitigation.getdocketparticipantsinfo
@jkey4 int
as

select a.name namep, a.role, b.name namea, b.title, c.mainname
from trlitigation.dockets_participants_stage a
left outer join trlitigation.dockets_participants_attorneys_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
left outer join trlitigation.dockets_participants_attorneys_lawfirm_stage c on b.jkey4 = c.jkey4 and b.jkey6 = c.jkey6 and b.jkey8 = c.jkey8
where a.jkey4 = @jkey4
union
select a.name namep, a.role, null namea, null title, c.mainname
from trlitigation.dockets_participants_stage a
left outer join trlitigation.dockets_participants_lawfirmswithoutattorneys_stage c on a.jkey4 = c.jkey4 and a.jkey6 = c.jkey6 
where a.jkey4 = @jkey4
order by a.role, a.name, c.mainname, b.name

--******try not including records where name, title, and mainname are null in first query?

select * from trlitigation.dockets_participants_stage
select * from trlitigation.dockets_participants_lawfirmswithoutattorneys_stage where jkey4 = 100 order by jkey6

select a.jkey4, a.jkey6, a.name namep, a.role, b.name namea, b.title, c.mainname
from trlitigation.dockets_participants_stage a
left outer join trlitigation.dockets_participants_attorneys_stage b on a.jkey4 = b.jkey4 and a.jkey6 = b.jkey6
left outer join trlitigation.dockets_participants_attorneys_lawfirm_stage c on b.jkey4 = c.jkey4 and b.jkey6 = c.jkey6 and b.jkey8 = c.jkey8
where a.jkey4 = 214
union
select a.jkey4, a.jkey6, a.name namep, a.role, null namea, null title, c.mainname
from trlitigation.dockets_participants_stage a
left outer join trlitigation.dockets_participants_lawfirmswithoutattorneys_stage c on a.jkey4 = c.jkey4 and a.jkey6 = c.jkey6 
where a.jkey4 = 214
order by a.role, a.name, c.mainname, b.name

select * from trlitigation.dockets_stage where jkey4 = 214 --0190246/2019, 2020-L-011166





--





