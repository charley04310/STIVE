USE [master]
GO
/****** Object:  Database [Stive]    Script Date: 09/12/2021 01:17:29 ******/
CREATE DATABASE [Stive]
 CONTAINMENT = NONE

GO
ALTER DATABASE [Stive] SET COMPATIBILITY_LEVEL = 130
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [Stive].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [Stive] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [Stive] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [Stive] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [Stive] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [Stive] SET ARITHABORT OFF 
GO
ALTER DATABASE [Stive] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [Stive] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [Stive] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [Stive] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [Stive] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [Stive] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [Stive] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [Stive] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [Stive] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [Stive] SET  DISABLE_BROKER 
GO
ALTER DATABASE [Stive] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [Stive] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [Stive] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [Stive] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [Stive] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [Stive] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [Stive] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [Stive] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [Stive] SET  MULTI_USER 
GO
ALTER DATABASE [Stive] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [Stive] SET DB_CHAINING OFF 
GO
ALTER DATABASE [Stive] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [Stive] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [Stive] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [Stive] SET QUERY_STORE = OFF
GO
USE [Stive]
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
USE [Stive]
GO
/****** Object:  Table [dbo].[Client]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Client](
	[Cli_Id] [int] IDENTITY(1,1) NOT NULL,
	[Cli_Nom] [nvarchar](500) NOT NULL,
	[Cli_Prenom] [nvarchar](100) NOT NULL,
	[Cli_DateNaissance] [datetime] NULL,
	[Cli_DateCreation] [datetime] NOT NULL,
	[Cli_Rol_Id] [int] NOT NULL,
	[Cli_Uti_Id] [int] NOT NULL,
 CONSTRAINT [PK_Client] PRIMARY KEY CLUSTERED 
(
	[Cli_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CommandeClient]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CommandeClient](
	[Coc_Id] [int] IDENTITY(1,1) NOT NULL,
	[Coc_DateCreation] [datetime] NOT NULL,
	[Coc_DateMaj] [datetime] NOT NULL,
	[Coc_Cli_Id] [int] NOT NULL,
	[Coc_Eta_Id] [int] NOT NULL,
 CONSTRAINT [PK_CommandeClient] PRIMARY KEY CLUSTERED 
(
	[Coc_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CommandeFournisseur]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CommandeFournisseur](
	[Cof_Id] [int] IDENTITY(1,1) NOT NULL,
	[Cof_DateCreation] [datetime] NOT NULL,
	[Cof_DateMaj] [datetime] NOT NULL,
	[Cof_Fou_Id] [int] NOT NULL,
	[Cof_Eta_Id] [int] NOT NULL,
 CONSTRAINT [PK_CommandeFournisseur] PRIMARY KEY CLUSTERED 
(
	[Cof_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ContenuCommandeClient]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ContenuCommandeClient](
	[Ccc_Coc_Id] [int] NOT NULL,
	[Ccc_DateCreation] [datetime] NOT NULL,
	[Ccc_DateMaj] [datetime] NOT NULL,
	[Ccc_Cli_Id] [int] NOT NULL,
 CONSTRAINT [PK_ContenuCommandeClient] PRIMARY KEY CLUSTERED 
(
	[Ccc_Coc_Id] ASC,
	[Ccc_DateCreation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ContenuCommandeFournisseur]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ContenuCommandeFournisseur](
	[Ccf_Cof_Id] [int] NOT NULL,
	[Ccf_DateCreation] [datetime] NOT NULL,
	[Ccf_DateMaj] [datetime] NOT NULL,
	[Ccf_Fou_Id] [int] NOT NULL,
 CONSTRAINT [PK_ContenuCommandeFournisseur] PRIMARY KEY CLUSTERED 
(
	[Ccf_Cof_Id] ASC,
	[Ccf_DateCreation] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Etat]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Etat](
	[Eta_Id] [int] IDENTITY(1,1) NOT NULL,
	[Eta_Libelle] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_Etat] PRIMARY KEY CLUSTERED 
(
	[Eta_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Fournisseur]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Fournisseur](
	[Fou_Id] [int] IDENTITY(1,1) NOT NULL,
	[Fou_NomDomaine] [nvarchar](100) NOT NULL,
	[Fou_NomResp] [nvarchar](100) NOT NULL,
	[Fou_TelResp] [nvarchar](100) NOT NULL,
	[Fou_MailResp] [nvarchar](100) NOT NULL,
	[Fou_Fonction] [nvarchar](100) NULL,
	[Fou_DateCreation] [datetime] NOT NULL,
	[Fou_Rol_Id] [int] NOT NULL,
	[Fou_Uti_Id] [int] NOT NULL,
 CONSTRAINT [PK_Fournisseur] PRIMARY KEY CLUSTERED 
(
	[Fou_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Image]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Image](
	[Img_Id] [int] IDENTITY(1,1) NOT NULL,
	[Img_Pro_Id] [int] NOT NULL,
	[Img_Adresse] [nvarchar](500) NOT NULL,
	[Img_Nom] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_Image] PRIMARY KEY CLUSTERED 
(
	[Img_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Lot]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Lot](
	[Lot_Id] [int] IDENTITY(1,1) NOT NULL,
	[Lot_Pro_Id] [int] NOT NULL,
	[Lot_Quantite] [float] NOT NULL,
	[Lot_Volume] [float] NOT NULL,
	[Lot_Dlc] [datetime] NOT NULL,
	[Lot_DateCreation] [datetime] NOT NULL,
 CONSTRAINT [PK_Lot] PRIMARY KEY CLUSTERED 
(
	[Lot_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Produit]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Produit](
	[Pro_Id] [int] IDENTITY(1,1) NOT NULL,
	[Pro_Typ_Id] [int] NOT NULL,
	[Pro_Nom] [nvarchar](100) NOT NULL,
	[Pro_Ref] [nvarchar](100) NULL,
	[Pro_Fou_Id] [int] NOT NULL,
	[Pro_Cepage] [nvarchar](100) NULL,
	[Pro_Annee] [int] NULL,
	[Pro_Prix] [float] NOT NULL,
	[Pro_PrixLitre] [float] NULL,
	[Pro_SeuilAlerte] [float] NULL,
	[Pro_Quantite] [float] NOT NULL,
	[Pro_Volume] [float] NULL,
	[Pro_Description] [nvarchar](max) NULL,
 CONSTRAINT [PK_Produit] PRIMARY KEY CLUSTERED 
(
	[Pro_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Role]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Role](
	[Rol_Id] [int] IDENTITY(1,1) NOT NULL,
	[Rol_Libelle] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_Role] PRIMARY KEY CLUSTERED 
(
	[Rol_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TypeProduit]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TypeProduit](
	[Typ_Id] [int] IDENTITY(1,1) NOT NULL,
	[Typ_Libelle] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_TypeProduit] PRIMARY KEY CLUSTERED 
(
	[Typ_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Utilisateur]    Script Date: 09/12/2021 01:17:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Utilisateur](
	[Uti_Id] [int] IDENTITY(1,1) NOT NULL,
	[Uti_Adresse] [nvarchar](500) NOT NULL,
	[Uti_CompAdresse] [nvarchar](100) NULL,
	[Uti_Cp] [nvarchar](50) NOT NULL,
	[Uti_Ville] [nvarchar](100) NOT NULL,
	[Uti_Pays] [nvarchar](100) NOT NULL,
	[Uti_TelContact] [nvarchar](50) NOT NULL,
	[Uti_Mdp] [nvarchar](500) NOT NULL,
	[Uti_VerifMdp] [nvarchar](500) NULL,
	[Uti_MailContact] [nvarchar](100) NOT NULL,
	[Uti_DateCreation] [datetime] NOT NULL,
 CONSTRAINT [PK_Utilisateur] PRIMARY KEY CLUSTERED 
(
	[Uti_Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[Client] ADD  CONSTRAINT [DF_Client_Cli_DateCreation]  DEFAULT (getdate()) FOR [Cli_DateCreation]
GO
ALTER TABLE [dbo].[CommandeClient] ADD  CONSTRAINT [DF_CommandeClient_Coc_DateCreation]  DEFAULT (getdate()) FOR [Coc_DateCreation]
GO
ALTER TABLE [dbo].[CommandeClient] ADD  CONSTRAINT [DF_CommandeClient_Coc_DateMaj]  DEFAULT (getdate()) FOR [Coc_DateMaj]
GO
ALTER TABLE [dbo].[CommandeFournisseur] ADD  CONSTRAINT [DF_CommandeFournisseur_Cof_DateCreation]  DEFAULT (getdate()) FOR [Cof_DateCreation]
GO
ALTER TABLE [dbo].[CommandeFournisseur] ADD  CONSTRAINT [DF_CommandeFournisseur_Cof_DateMaj]  DEFAULT (getdate()) FOR [Cof_DateMaj]
GO
ALTER TABLE [dbo].[ContenuCommandeClient] ADD  CONSTRAINT [DF_ContenuCommandeClient_Ccc_DateCreation]  DEFAULT (getdate()) FOR [Ccc_DateCreation]
GO
ALTER TABLE [dbo].[ContenuCommandeClient] ADD  CONSTRAINT [DF_ContenuCommandeClient_Ccc_DateMaj]  DEFAULT (getdate()) FOR [Ccc_DateMaj]
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur] ADD  CONSTRAINT [DF_ContenuCommandeFournisseur_CoCo_DateCreation]  DEFAULT (getdate()) FOR [Ccf_DateCreation]
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur] ADD  CONSTRAINT [DF_ContenuCommandeFournisseur_CoCo_DateMaj]  DEFAULT (getdate()) FOR [Ccf_DateMaj]
GO
ALTER TABLE [dbo].[Fournisseur] ADD  CONSTRAINT [DF_Fournisseur_Fou_DateCreation]  DEFAULT (getdate()) FOR [Fou_DateCreation]
GO
ALTER TABLE [dbo].[Utilisateur] ADD  CONSTRAINT [DF_Utilisateur_Uti_DateCreation]  DEFAULT (getdate()) FOR [Uti_DateCreation]
GO
ALTER TABLE [dbo].[Client]  WITH CHECK ADD  CONSTRAINT [FK_Client_Role] FOREIGN KEY([Cli_Rol_Id])
REFERENCES [dbo].[Role] ([Rol_Id])
GO
ALTER TABLE [dbo].[Client] CHECK CONSTRAINT [FK_Client_Role]
GO
ALTER TABLE [dbo].[Client]  WITH CHECK ADD  CONSTRAINT [FK_Client_Utilisateur] FOREIGN KEY([Cli_Uti_Id])
REFERENCES [dbo].[Utilisateur] ([Uti_Id])
GO
ALTER TABLE [dbo].[Client] CHECK CONSTRAINT [FK_Client_Utilisateur]
GO
ALTER TABLE [dbo].[CommandeClient]  WITH CHECK ADD  CONSTRAINT [FK_CommandeClient_Client] FOREIGN KEY([Coc_Cli_Id])
REFERENCES [dbo].[Client] ([Cli_Id])
GO
ALTER TABLE [dbo].[CommandeClient] CHECK CONSTRAINT [FK_CommandeClient_Client]
GO
ALTER TABLE [dbo].[CommandeClient]  WITH CHECK ADD  CONSTRAINT [FK_CommandeClient_Etat] FOREIGN KEY([Coc_Eta_Id])
REFERENCES [dbo].[Etat] ([Eta_Id])
GO
ALTER TABLE [dbo].[CommandeClient] CHECK CONSTRAINT [FK_CommandeClient_Etat]
GO
ALTER TABLE [dbo].[CommandeFournisseur]  WITH CHECK ADD  CONSTRAINT [FK_CommandeFournisseur_Etat] FOREIGN KEY([Cof_Eta_Id])
REFERENCES [dbo].[Etat] ([Eta_Id])
GO
ALTER TABLE [dbo].[CommandeFournisseur] CHECK CONSTRAINT [FK_CommandeFournisseur_Etat]
GO
ALTER TABLE [dbo].[CommandeFournisseur]  WITH CHECK ADD  CONSTRAINT [FK_CommandeFournisseur_Fournisseur] FOREIGN KEY([Cof_Fou_Id])
REFERENCES [dbo].[Fournisseur] ([Fou_Id])
GO
ALTER TABLE [dbo].[CommandeFournisseur] CHECK CONSTRAINT [FK_CommandeFournisseur_Fournisseur]
GO
ALTER TABLE [dbo].[ContenuCommandeClient]  WITH CHECK ADD  CONSTRAINT [FK_ContenuCommandeClient_Client] FOREIGN KEY([Ccc_Cli_Id])
REFERENCES [dbo].[Client] ([Cli_Id])
GO
ALTER TABLE [dbo].[ContenuCommandeClient] CHECK CONSTRAINT [FK_ContenuCommandeClient_Client]
GO
ALTER TABLE [dbo].[ContenuCommandeClient]  WITH CHECK ADD  CONSTRAINT [FK_ContenuCommandeClient_CommandeClient] FOREIGN KEY([Ccc_Coc_Id])
REFERENCES [dbo].[CommandeClient] ([Coc_Id])
GO
ALTER TABLE [dbo].[ContenuCommandeClient] CHECK CONSTRAINT [FK_ContenuCommandeClient_CommandeClient]
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur]  WITH CHECK ADD  CONSTRAINT [FK_ContenuCommandeFournisseur_CommandeFournisseur] FOREIGN KEY([Ccf_Cof_Id])
REFERENCES [dbo].[CommandeFournisseur] ([Cof_Id])
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur] CHECK CONSTRAINT [FK_ContenuCommandeFournisseur_CommandeFournisseur]
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur]  WITH CHECK ADD  CONSTRAINT [FK_ContenuCommandeFournisseur_Fournisseur] FOREIGN KEY([Ccf_Fou_Id])
REFERENCES [dbo].[Fournisseur] ([Fou_Id])
GO
ALTER TABLE [dbo].[ContenuCommandeFournisseur] CHECK CONSTRAINT [FK_ContenuCommandeFournisseur_Fournisseur]
GO
ALTER TABLE [dbo].[Fournisseur]  WITH CHECK ADD  CONSTRAINT [FK_Fournisseur_Role] FOREIGN KEY([Fou_Rol_Id])
REFERENCES [dbo].[Role] ([Rol_Id])
GO
ALTER TABLE [dbo].[Fournisseur] CHECK CONSTRAINT [FK_Fournisseur_Role]
GO
ALTER TABLE [dbo].[Fournisseur]  WITH CHECK ADD  CONSTRAINT [FK_Fournisseur_Utilisateur] FOREIGN KEY([Fou_Uti_Id])
REFERENCES [dbo].[Utilisateur] ([Uti_Id])
GO
ALTER TABLE [dbo].[Fournisseur] CHECK CONSTRAINT [FK_Fournisseur_Utilisateur]
GO
ALTER TABLE [dbo].[Image]  WITH CHECK ADD  CONSTRAINT [FK_Image_Produit] FOREIGN KEY([Img_Pro_Id])
REFERENCES [dbo].[Produit] ([Pro_Id])
GO
ALTER TABLE [dbo].[Image] CHECK CONSTRAINT [FK_Image_Produit]
GO
ALTER TABLE [dbo].[Lot]  WITH CHECK ADD  CONSTRAINT [FK_Lot_Produit] FOREIGN KEY([Lot_Pro_Id])
REFERENCES [dbo].[Produit] ([Pro_Id])
GO
ALTER TABLE [dbo].[Lot] CHECK CONSTRAINT [FK_Lot_Produit]
GO
ALTER TABLE [dbo].[Produit]  WITH CHECK ADD  CONSTRAINT [FK_Produit_Fournisseur] FOREIGN KEY([Pro_Fou_Id])
REFERENCES [dbo].[Fournisseur] ([Fou_Id])
GO
ALTER TABLE [dbo].[Produit] CHECK CONSTRAINT [FK_Produit_Fournisseur]
GO
ALTER TABLE [dbo].[Produit]  WITH CHECK ADD  CONSTRAINT [FK_Produit_TypeProduit] FOREIGN KEY([Pro_Typ_Id])
REFERENCES [dbo].[TypeProduit] ([Typ_Id])
GO
ALTER TABLE [dbo].[Produit] CHECK CONSTRAINT [FK_Produit_TypeProduit]
GO
USE [master]
GO
ALTER DATABASE [Stive] SET  READ_WRITE 
GO
USE [Stive]

insert into TypeProduit(Typ_Libelle) values ('Vin rouge'),('Vin blanc'),('Vin rosé'),('Produit terroir')

insert into Role (Rol_Libelle) values ('client'),('fournisseur'),('admin')
GO