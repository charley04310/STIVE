INSERT INTO dbo.Fournisseur (Fou_NomDomaine, Fou_NomResp, Fou_TelResp, Fou_MailResp, Fou_Fonction, Fou_Rol_Id, Fou_Uti_Id) VALUES
    ( 'Chateaux Margaux', 'Didier', '0609090909', 'g@gmail.com', 'Directeur', (SELECT Rol_Id from dbo.role WHERE Rol_Libelle='Fournisseur'), (SELECT Uti_Id from dbo.Utilisateur WHERE Uti_MailContact='jojo@gmail.com') )
 