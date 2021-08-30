USE [OnFire_Prod]
GO

/****** Object:  StoredProcedure [onfire].[questionanswercreate]    Script Date: 11/21/2019 4:45:33 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [onfire].[questionanswercreate]
@question nvarchar(1000), @answertypeid int, @singleanswer nvarchar(1000), @sqlquery nvarchar(4000), @columnnumber int, @userid int
as

declare @date datetime
select @date = getdate()

insert into onfire.questionanswer(question, answertypeid, singleanswer, sqlquery, columnnumber, processedid, createdate, updatedate, createdby, updatedby)
select @question, @answertypeid, @singleanswer, @sqlquery, @columnnumber, 1, @date, @date, @userid, @userid
GO

select * from onfire.questionanswer

select * from onfire.answertypes

design main page to create main question
button to create child questions, separate page
after submit brings you back to main question page showing any children created as well
navigation back to main tool?, where do we put all these buttons?

admin page to create a new question

admin page to alter a single question

admin page to see all questions and pick one to edit

****all of this for the single answer question type only for now

select * from onfire.questionanswer
select * from onfire.questionanswerinformation

update onfire.questionanswer
set answertypeid = null, singleanswer = null, columnnumber = null
where id = 3

create procedure onfire.getquestionanswerssingleanswer
as

--for edit button take you to parent question page where you could the alter\delete children and delete main if no children exist

select a.question, a.singleanswer, b.information, 'Edit'
from onfire.questionanswer a
join onfire.questionanswerinformation b on a.id = b.questionaswerid
where a.answertypeid = 2
and a.parentid is null








