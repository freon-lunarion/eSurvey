/*
 Navicat Premium Data Transfer

 Source Server         : Portal
 Source Server Type    : SQL Server
 Source Server Version : 10501600
 Source Host           : 10.9.70.33
 Source Database       : eSurvey
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 10501600
 File Encoding         : utf-8

 Date: 08/10/2016 15:53:09 PM
*/

-- ----------------------------
--  Table structure for GES_M_dimension
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_dimension]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_dimension]
GO
CREATE TABLE [dbo].[GES_M_dimension] (
	[dimension_id] int IDENTITY(1,1) NOT NULL,
	[dimension_code] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[dimension_text] varchar(50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[variable_id] int NOT NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_indicator
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_indicator]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_indicator]
GO
CREATE TABLE [dbo].[GES_M_indicator] (
	[indicator_id] int IDENTITY(1,1) NOT NULL,
	[indicator_code] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[indicator_text] varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[dimension_id] int NOT NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_kuesioner
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_kuesioner]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_kuesioner]
GO
CREATE TABLE [dbo].[GES_M_kuesioner] (
	[kuesioner_id] int IDENTITY(1,1) NOT NULL,
	[survey_type_id] int NULL,
	[kuesioner_code] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[title] varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[theme] varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[introduction] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[start_time] datetime NOT NULL,
	[end_time] datetime NOT NULL,
	[abstain_text] varchar(20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[skip_quota] int NULL,
	[agreement_text] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[contract_active] bit NULL,
	[contract_min_years] int NULL,
	[contract_min_months] int NULL,
	[contract_min_days] int NULL,
	[contract_max_years] int NULL,
	[contract_max_months] int NULL,
	[contract_max_days] int NULL,
	[permanent_active] bit NULL,
	[permanent_min_years] int NULL,
	[permanent_min_months] int NULL,
	[permanent_min_days] int NULL,
	[permanent_max_years] int NULL,
	[permanent_max_months] int NULL,
	[permanent_max_days] int NULL,
	[position_min_years] int NULL,
	[position_min_months] int NULL,
	[position_min_days] int NULL,
	[position_max_years] int NULL,
	[position_max_months] int NULL,
	[position_max_days] int NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL,
	[is_all] bit NOT NULL,
	[method] int NOT NULL,
	[guide] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[term] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_question
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_question]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_question]
GO
CREATE TABLE [dbo].[GES_M_question] (
	[question_id] int IDENTITY(1,1) NOT NULL,
	[question_code] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[question_text] text COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[type] int NOT NULL,
	[survey_type_id] int NOT NULL,
	[variable_id] int NULL,
	[dimension_id] int NULL,
	[indicator_id] int NULL,
	[min_val] int NULL,
	[max_val] int NULL,
	[min_text] varchar(30) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[max_text] varchar(30) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL,
	[abstain_flag] bit NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_question_option
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_question_option]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_question_option]
GO
CREATE TABLE [dbo].[GES_M_question_option] (
	[option_id] int IDENTITY(1,1) NOT NULL,
	[question_id] int NOT NULL,
	[option_text] text COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[option_value] int NOT NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_question_set
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_question_set]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_question_set]
GO
CREATE TABLE [dbo].[GES_M_question_set] (
	[question_set_id] int IDENTITY(1,1) NOT NULL,
	[section_id] int NOT NULL,
	[question_id] int NOT NULL,
	[order] int NOT NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_responden_unit
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_responden_unit]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_responden_unit]
GO
CREATE TABLE [dbo].[GES_M_responden_unit] (
	[responden_unit_id] int IDENTITY(1,1) NOT NULL,
	[kuesioner_id] int NOT NULL,
	[org_id] int NOT NULL,
	[org_name] varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[contract_active] bit NULL,
	[contract_min_years] int NULL,
	[contract_min_months] int NULL,
	[contract_min_days] int NULL,
	[contract_max_years] int NULL,
	[contract_max_months] int NULL,
	[contract_max_days] int NULL,
	[permanent_active] int NULL,
	[permanent_min_years] int NULL,
	[permanent_min_months] int NULL,
	[permanent_min_days] int NULL,
	[permanent_max_years] int NULL,
	[permanent_max_months] int NULL,
	[permanent_max_days] int NULL,
	[position_min_years] int NULL,
	[position_min_months] int NULL,
	[position_min_days] int NULL,
	[position_max_years] int NULL,
	[position_max_months] int NULL,
	[position_max_days] int NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_section
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_section]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_section]
GO
CREATE TABLE [dbo].[GES_M_section] (
	[section_id] int IDENTITY(1,1) NOT NULL,
	[kuesioner_id] int NOT NULL,
	[section_name] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[order] int NOT NULL,
	[description] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_survey_type
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_survey_type]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_survey_type]
GO
CREATE TABLE [dbo].[GES_M_survey_type] (
	[survey_type_id] int IDENTITY(1,1) NOT NULL,
	[survey_type_name] varchar(50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[description] text COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NULL,
	[is_active] bit NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_M_variable
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_M_variable]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_M_variable]
GO
CREATE TABLE [dbo].[GES_M_variable] (
	[variable_id] int IDENTITY(1,1) NOT NULL,
	[variable_code] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[variable_text] varchar(50) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[survey_type_id] int NOT NULL,
	[insert_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[insert_on] datetime NOT NULL,
	[update_by] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	[update_on] datetime NOT NULL,
	[is_active] bit NOT NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_T_answer
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_T_answer]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_T_answer]
GO
CREATE TABLE [dbo].[GES_T_answer] (
	[answer_id] int IDENTITY(1,1) NOT NULL,
	[responden_id] int NULL,
	[question_id] int NULL,
	[value] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[value_text] text COLLATE SQL_Latin1_General_CP1_CI_AS NULL
)
ON [PRIMARY]
TEXTIMAGE_ON [PRIMARY]
GO

-- ----------------------------
--  Table structure for GES_T_responden
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_T_responden]') AND type IN ('U'))
	DROP TABLE [dbo].[GES_T_responden]
GO
CREATE TABLE [dbo].[GES_T_responden] (
	[responden_id] int IDENTITY(1,1) NOT NULL,
	[kuesioner_id] int NULL,
	[nik] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[gender] bit NULL,
	[birthdate] date NULL,
	[birthplace] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[religion] varchar(20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[join_date] date NULL,
	[permanent_date] date NULL,
	[status_flag] varchar(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[position_id] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[position_name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[chief_status] int NULL,
	[esg] varchar(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[esg_text] varchar(30) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[unit_id] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[unit_name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[div_id] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[div_name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[dept_id] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[dept_name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[sect_id] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[sect_name] varchar(200) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[is_submitted] bit NULL,
	[submitted_on] datetime NULL,
	[skip_count] int NULL,
	[is_sap] bit NULL
)
ON [PRIMARY]
GO

-- ----------------------------
--  View structure for [dbo].[GES_V_question_bank]
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_V_question_bank]') AND type IN ('V'))
	DROP VIEW [dbo].[GES_V_question_bank]
GO
CREATE VIEW [dbo].[GES_V_question_bank] AS SELECT     dbo.GES_M_question.question_id, dbo.GES_M_question.question_code, dbo.GES_M_question.question_text, dbo.GES_M_question.type, 
                      dbo.GES_M_question.survey_type_id, dbo.GES_M_question.variable_id, dbo.GES_M_question.dimension_id, dbo.GES_M_question.indicator_id, 
                      dbo.GES_M_question.min_val, dbo.GES_M_question.max_val, dbo.GES_M_question.min_text, dbo.GES_M_question.max_text, 
                      dbo.GES_M_question.insert_by, dbo.GES_M_question.insert_on, dbo.GES_M_question.update_by, dbo.GES_M_question.update_on, 
                      dbo.GES_M_question.is_active, dbo.GES_M_question.abstain_flag, dbo.GES_M_variable.variable_text, dbo.GES_M_variable.variable_code, 
                      dbo.GES_M_dimension.dimension_code, dbo.GES_M_dimension.dimension_text, dbo.GES_M_indicator.indicator_code, 
                      dbo.GES_M_indicator.indicator_text, dbo.GES_M_survey_type.survey_type_name
FROM         dbo.GES_M_question INNER JOIN
                      dbo.GES_M_survey_type ON dbo.GES_M_question.survey_type_id = dbo.GES_M_survey_type.survey_type_id LEFT OUTER JOIN
                      dbo.GES_M_variable ON dbo.GES_M_survey_type.survey_type_id = dbo.GES_M_variable.survey_type_id AND 
                      dbo.GES_M_question.variable_id = dbo.GES_M_variable.variable_id LEFT OUTER JOIN
                      dbo.GES_M_dimension ON dbo.GES_M_question.dimension_id = dbo.GES_M_dimension.dimension_id AND 
                      dbo.GES_M_variable.variable_id = dbo.GES_M_dimension.variable_id LEFT OUTER JOIN
                      dbo.GES_M_indicator ON dbo.GES_M_question.indicator_id = dbo.GES_M_indicator.indicator_id AND 
                      dbo.GES_M_dimension.dimension_id = dbo.GES_M_indicator.dimension_id


GO

-- ----------------------------
--  View structure for [dbo].[GES_V_category]
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_V_category]') AND type IN ('V'))
	DROP VIEW [dbo].[GES_V_category]
GO
CREATE VIEW [dbo].[GES_V_category] AS SELECT     dbo.GES_M_indicator.indicator_id, dbo.GES_M_indicator.indicator_code, dbo.GES_M_indicator.indicator_text, dbo.GES_M_indicator.dimension_id, dbo.GES_M_indicator.insert_by, 
                      dbo.GES_M_indicator.insert_on, dbo.GES_M_indicator.update_by, dbo.GES_M_indicator.update_on, dbo.GES_M_indicator.is_active, dbo.GES_M_dimension.dimension_code, 
                      dbo.GES_M_dimension.dimension_text, dbo.GES_M_dimension.variable_id, dbo.GES_M_variable.variable_code, dbo.GES_M_variable.variable_text, dbo.GES_M_variable.survey_type_id, 
                      dbo.GES_M_survey_type.survey_type_name
FROM         dbo.GES_M_survey_type INNER JOIN
                      dbo.GES_M_variable ON dbo.GES_M_survey_type.survey_type_id = dbo.GES_M_variable.survey_type_id INNER JOIN
                      dbo.GES_M_dimension ON dbo.GES_M_variable.variable_id = dbo.GES_M_dimension.variable_id INNER JOIN
                      dbo.GES_M_indicator ON dbo.GES_M_dimension.dimension_id = dbo.GES_M_indicator.dimension_id


GO

-- ----------------------------
--  View structure for [dbo].[GES_V_question_set]
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_V_question_set]') AND type IN ('V'))
	DROP VIEW [dbo].[GES_V_question_set]
GO
CREATE VIEW [dbo].[GES_V_question_set] AS SELECT     dbo.GES_M_question_set.question_set_id, dbo.GES_M_question_set.section_id, dbo.GES_M_section.section_name, dbo.GES_M_section.[order] AS section_order, 
                      dbo.GES_M_question_set.question_id, dbo.GES_M_question_set.[order] AS question_order, dbo.GES_M_question_set.insert_by, dbo.GES_M_question_set.insert_on, 
                      dbo.GES_M_question_set.update_by, dbo.GES_M_question_set.update_on, dbo.GES_M_question_set.is_active, dbo.GES_V_question_bank.question_code, 
                      dbo.GES_V_question_bank.question_text, dbo.GES_V_question_bank.type, dbo.GES_V_question_bank.survey_type_id, dbo.GES_V_question_bank.survey_type_name, 
                      dbo.GES_V_question_bank.variable_id, dbo.GES_V_question_bank.variable_code, dbo.GES_V_question_bank.variable_text, dbo.GES_V_question_bank.dimension_id, 
                      dbo.GES_V_question_bank.dimension_code, dbo.GES_V_question_bank.dimension_text, dbo.GES_V_question_bank.indicator_id, dbo.GES_V_question_bank.indicator_code, 
                      dbo.GES_V_question_bank.indicator_text, dbo.GES_M_section.kuesioner_id, dbo.GES_M_kuesioner.title, dbo.GES_M_kuesioner.kuesioner_code, dbo.GES_V_question_bank.min_val, 
                      dbo.GES_V_question_bank.max_val, dbo.GES_V_question_bank.min_text, dbo.GES_V_question_bank.max_text, dbo.GES_V_question_bank.abstain_flag
FROM         dbo.GES_M_question_set INNER JOIN
                      dbo.GES_M_section ON dbo.GES_M_question_set.section_id = dbo.GES_M_section.section_id INNER JOIN
                      dbo.GES_V_question_bank ON dbo.GES_M_question_set.question_id = dbo.GES_V_question_bank.question_id INNER JOIN
                      dbo.GES_M_kuesioner ON dbo.GES_M_section.kuesioner_id = dbo.GES_M_kuesioner.kuesioner_id


GO

-- ----------------------------
--  View structure for [dbo].[GES_V_answer]
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID('[dbo].[GES_V_answer]') AND type IN ('V'))
	DROP VIEW [dbo].[GES_V_answer]
GO
CREATE VIEW [dbo].[GES_V_answer] AS SELECT     dbo.GES_T_answer.answer_id, dbo.GES_T_answer.responden_id, dbo.GES_T_answer.question_id, dbo.GES_V_question_bank.question_text, 
                      dbo.GES_V_question_bank.question_code, dbo.GES_T_answer.value, dbo.GES_T_answer.value_text, dbo.GES_T_responden.kuesioner_id, 
                      dbo.GES_T_responden.gender, dbo.GES_T_responden.birthdate, dbo.GES_T_responden.birthplace, dbo.GES_T_responden.religion, dbo.GES_T_responden.join_date, 
                      dbo.GES_T_responden.permanent_date, dbo.GES_T_responden.status_flag, dbo.GES_T_responden.chief_status, dbo.GES_T_responden.position_id, 
                      dbo.GES_T_responden.position_name, dbo.GES_T_responden.esg, dbo.GES_T_responden.esg_text, dbo.GES_T_responden.unit_id, 
                      dbo.GES_T_responden.unit_name, dbo.GES_T_responden.div_id, dbo.GES_T_responden.div_name, dbo.GES_T_responden.dept_id, 
                      dbo.GES_T_responden.dept_name, dbo.GES_T_responden.sect_id, dbo.GES_T_responden.sect_name, dbo.GES_T_responden.skip_count, 
                      dbo.GES_V_question_bank.type, dbo.GES_V_question_bank.variable_id, dbo.GES_V_question_bank.variable_code, dbo.GES_V_question_bank.dimension_id, 
                      dbo.GES_V_question_bank.dimension_code, dbo.GES_V_question_bank.indicator_id, dbo.GES_V_question_bank.indicator_code, dbo.GES_T_responden.is_submitted, 
                      dbo.GES_T_responden.submitted_on, dbo.GES_T_responden.nik
FROM         dbo.GES_T_answer INNER JOIN
                      dbo.GES_T_responden ON dbo.GES_T_answer.responden_id = dbo.GES_T_responden.responden_id INNER JOIN
                      dbo.GES_V_question_bank ON dbo.GES_T_answer.question_id = dbo.GES_V_question_bank.question_id

GO

-- ----------------------------
--  Procedure structure for [dbo].Get_answer
-- ----------------------------
CREATE PROCEDURE [dbo].[Get_answer]  @kuesionerid integer, @unitid integer

AS
BEGIN
	DECLARE @cols AS NVARCHAR(MAX),
    @query  AS NVARCHAR(MAX)


	select @cols = STUFF((SELECT ',' + QUOTENAME(question_id) 
				from dbo.GES_V_question_set WHERE kuesioner_id = @kuesionerid AND is_active = 1
				ORDER BY section_order, question_order
		FOR XML PATH(''), TYPE
		).value('.', 'NVARCHAR(MAX)') 
	,1,1,'')
	
	        
	set @query = 'SELECT responden_id, nik, gender, birthdate,birthplace, religion, join_date, permanent_date, status_flag, chief_status,position_id,position_name, esg , esg_text, unit_id, unit_name, div_id, div_name, dept_id, dept_name, sect_id, sect_name, submitted_on, ' + @cols + ' 
				 FROM 
				 (
					select responden_id,nik, gender, birthdate,birthplace, religion, join_date, permanent_date, status_flag, chief_status,position_id,position_name, esg , esg_text, unit_id, unit_name, div_id, div_name, dept_id, dept_name, sect_id, sect_name, submitted_on, question_id , value
					from dbo.GES_V_answer WHERE is_submitted = 1 AND kuesioner_id = ' + convert(varchar(5),@kuesionerid) + ' AND (unit_id = '+ convert(varchar(10),@unitid) + ' OR (datalength(unit_id) = 0 AND div_id = '+ convert(varchar(10),@unitid) + ' ))
				) x
				pivot 
				(
					min(value)
					for question_id in (' + @cols + ')
				) p '
	execute(@query)
END


GO


-- ----------------------------
--  Primary key structure for table GES_M_dimension
-- ----------------------------
ALTER TABLE [dbo].[GES_M_dimension] ADD
	CONSTRAINT [PK_GES_M_dimension] PRIMARY KEY CLUSTERED ([dimension_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_indicator
-- ----------------------------
ALTER TABLE [dbo].[GES_M_indicator] ADD
	CONSTRAINT [PK_GES_M_indicator] PRIMARY KEY CLUSTERED ([indicator_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_kuesioner
-- ----------------------------
ALTER TABLE [dbo].[GES_M_kuesioner] ADD
	CONSTRAINT [PK_dbo.GES_M_kuesioner] PRIMARY KEY CLUSTERED ([kuesioner_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_question
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question] ADD
	CONSTRAINT [PK_GES_M_question] PRIMARY KEY CLUSTERED ([question_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_question_option
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_option] ADD
	CONSTRAINT [PK_GES_M_question_option] PRIMARY KEY CLUSTERED ([option_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_question_set
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_set] ADD
	CONSTRAINT [PK_GES_M_question_set] PRIMARY KEY CLUSTERED ([question_set_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_responden_unit
-- ----------------------------
ALTER TABLE [dbo].[GES_M_responden_unit] ADD
	CONSTRAINT [PK_GES_M_responden_unit] PRIMARY KEY CLUSTERED ([responden_unit_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_section
-- ----------------------------
ALTER TABLE [dbo].[GES_M_section] ADD
	CONSTRAINT [PK_GES_M_section] PRIMARY KEY CLUSTERED ([section_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_survey_type
-- ----------------------------
ALTER TABLE [dbo].[GES_M_survey_type] ADD
	CONSTRAINT [PK_GES_M_survey_type] PRIMARY KEY CLUSTERED ([survey_type_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_M_variable
-- ----------------------------
ALTER TABLE [dbo].[GES_M_variable] ADD
	CONSTRAINT [PK_GES_M_variable] PRIMARY KEY CLUSTERED ([variable_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_T_answer
-- ----------------------------
ALTER TABLE [dbo].[GES_T_answer] ADD
	CONSTRAINT [PK_GES_T_answer] PRIMARY KEY CLUSTERED ([answer_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Primary key structure for table GES_T_responden
-- ----------------------------
ALTER TABLE [dbo].[GES_T_responden] ADD
	CONSTRAINT [PK_GES_T_responden] PRIMARY KEY CLUSTERED ([responden_id]) 
	WITH (PAD_INDEX = OFF,
		IGNORE_DUP_KEY = OFF,
		ALLOW_ROW_LOCKS = ON,
		ALLOW_PAGE_LOCKS = ON)
	ON [default]
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_dimension
-- ----------------------------
ALTER TABLE [dbo].[GES_M_dimension] ADD
	CONSTRAINT [FK_GES_M_dimension_GES_M_variable] FOREIGN KEY ([variable_id]) REFERENCES [dbo].[GES_M_variable] ([variable_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_indicator
-- ----------------------------
ALTER TABLE [dbo].[GES_M_indicator] ADD
	CONSTRAINT [FK_GES_M_indicator_GES_M_dimension] FOREIGN KEY ([dimension_id]) REFERENCES [dbo].[GES_M_dimension] ([dimension_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_kuesioner
-- ----------------------------
ALTER TABLE [dbo].[GES_M_kuesioner] ADD
	CONSTRAINT [FK_GES_M_kuesioner_GES_M_survey_type] FOREIGN KEY ([survey_type_id]) REFERENCES [dbo].[GES_M_survey_type] ([survey_type_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_question
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question] ADD
	CONSTRAINT [FK_GES_M_question_GES_M_dimension] FOREIGN KEY ([dimension_id]) REFERENCES [dbo].[GES_M_dimension] ([dimension_id]) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT [FK_GES_M_question_GES_M_indicator] FOREIGN KEY ([indicator_id]) REFERENCES [dbo].[GES_M_indicator] ([indicator_id]) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT [FK_GES_M_question_GES_M_survey_type] FOREIGN KEY ([survey_type_id]) REFERENCES [dbo].[GES_M_survey_type] ([survey_type_id]) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT [FK_GES_M_question_GES_M_variable] FOREIGN KEY ([variable_id]) REFERENCES [dbo].[GES_M_variable] ([variable_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_question_option
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_option] ADD
	CONSTRAINT [FK_GES_M_question_option_GES_M_question] FOREIGN KEY ([question_id]) REFERENCES [dbo].[GES_M_question] ([question_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_question_set
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_set] ADD
	CONSTRAINT [FK_GES_M_question_set_GES_M_question] FOREIGN KEY ([question_id]) REFERENCES [dbo].[GES_M_question] ([question_id]) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT [FK_GES_M_question_set_GES_M_section] FOREIGN KEY ([section_id]) REFERENCES [dbo].[GES_M_section] ([section_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_responden_unit
-- ----------------------------
ALTER TABLE [dbo].[GES_M_responden_unit] ADD
	CONSTRAINT [FK_GES_M_responden_unit_GES_M_kuesioner] FOREIGN KEY ([kuesioner_id]) REFERENCES [dbo].[GES_M_kuesioner] ([kuesioner_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_section
-- ----------------------------
ALTER TABLE [dbo].[GES_M_section] ADD
	CONSTRAINT [FK_GES_M_section_GES_M_kuesioner] FOREIGN KEY ([kuesioner_id]) REFERENCES [dbo].[GES_M_kuesioner] ([kuesioner_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_M_variable
-- ----------------------------
ALTER TABLE [dbo].[GES_M_variable] ADD
	CONSTRAINT [FK_GES_M_variable_GES_M_survey_type] FOREIGN KEY ([survey_type_id]) REFERENCES [dbo].[GES_M_survey_type] ([survey_type_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_T_answer
-- ----------------------------
ALTER TABLE [dbo].[GES_T_answer] ADD
	CONSTRAINT [FK_GES_T_answer_GES_T_responden] FOREIGN KEY ([responden_id]) REFERENCES [dbo].[GES_T_responden] ([responden_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Foreign keys structure for table GES_T_responden
-- ----------------------------
ALTER TABLE [dbo].[GES_T_responden] ADD
	CONSTRAINT [FK_GES_T_responden_GES_M_kuesioner] FOREIGN KEY ([kuesioner_id]) REFERENCES [dbo].[GES_M_kuesioner] ([kuesioner_id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

-- ----------------------------
--  Options for table GES_M_dimension
-- ----------------------------
ALTER TABLE [dbo].[GES_M_dimension] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_dimension]', RESEED, 15)
GO

-- ----------------------------
--  Options for table GES_M_indicator
-- ----------------------------
ALTER TABLE [dbo].[GES_M_indicator] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_indicator]', RESEED, 1)
GO

-- ----------------------------
--  Options for table GES_M_kuesioner
-- ----------------------------
ALTER TABLE [dbo].[GES_M_kuesioner] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_kuesioner]', RESEED, 8)
GO

-- ----------------------------
--  Options for table GES_M_question
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_question]', RESEED, 56)
GO

-- ----------------------------
--  Options for table GES_M_question_option
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_option] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_question_option]', RESEED, 11)
GO

-- ----------------------------
--  Options for table GES_M_question_set
-- ----------------------------
ALTER TABLE [dbo].[GES_M_question_set] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_question_set]', RESEED, 255)
GO

-- ----------------------------
--  Options for table GES_M_responden_unit
-- ----------------------------
ALTER TABLE [dbo].[GES_M_responden_unit] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_responden_unit]', RESEED, 47)
GO

-- ----------------------------
--  Options for table GES_M_section
-- ----------------------------
ALTER TABLE [dbo].[GES_M_section] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_section]', RESEED, 38)
GO

-- ----------------------------
--  Options for table GES_M_survey_type
-- ----------------------------
ALTER TABLE [dbo].[GES_M_survey_type] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_survey_type]', RESEED, 3)
GO

-- ----------------------------
--  Options for table GES_M_variable
-- ----------------------------
ALTER TABLE [dbo].[GES_M_variable] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_M_variable]', RESEED, 3)
GO

-- ----------------------------
--  Options for table GES_T_answer
-- ----------------------------
ALTER TABLE [dbo].[GES_T_answer] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_T_answer]', RESEED, 584404)
GO

-- ----------------------------
--  Options for table GES_T_responden
-- ----------------------------
ALTER TABLE [dbo].[GES_T_responden] SET (LOCK_ESCALATION = TABLE)
GO
DBCC CHECKIDENT ('[dbo].[GES_T_responden]', RESEED, 16257)
GO

