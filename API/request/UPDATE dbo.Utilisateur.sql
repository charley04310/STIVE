UPDATE dbo.Utilisateur 
SET Uti_Adresse='', Uti_CompAdresse=:Uti_CompAdresse, Uti_Cp=:Uti_Cp, Uti_Ville=:Uti_Ville, Uti_Pays=:Uti_Pays, Uti_TelContact=:Uti_TelContact, Uti_Mdp=:Uti_Mdp, Uti_MailContact=:Uti_MailContact
WHERE Uti_Id=$_SESSION['user_id'] or (Uti_Id=1 AND Uti_Cli_Id=