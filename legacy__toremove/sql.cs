using System;
using System.Xml;
using System.Data;
using System.Data.SqlClient;
public class Afficheur
{
	public static int Main(string[] args)
	{
		string sql = "";
		try{
			// Test if input arguments were supplied:
			if (args.Length < 3)
			{
				Console.WriteLine("Usage :");
				Console.WriteLine("Sql.exe ISODATE CODEETABLISSEMENT FICHIER");
				Console.WriteLine("");
				Console.WriteLine("ISODATE : Date du planing souhaité au format YYYY-MM-DD");
				Console.WriteLine("");
				Console.WriteLine("CODEETABLISSEMENT : Entier représentant le numéro du centre dans la base FNG");
				Console.WriteLine("");
				Console.WriteLine("FICHIER : Chemin du fichier de sortie du XML");
				Console.WriteLine("");
				Console.WriteLine("Or :");
				Console.WriteLine("Sql.exe Salle CODEETABLISSEMENT FICHIER");
				Console.WriteLine("");
				Console.WriteLine("Exemple :");
				Console.WriteLine("Sql.exe Salle 6 SallesdeBordeaux.xml");
				return 1;
			}

			
			string connectionString = "Server=bddcom;Database=FNG;User Id=dtrimoulet; Password=dtrimoulet";
			SqlConnection connection = new SqlConnection(connectionString);
			DataSet dataset = new DataSet();
			
			if ( args[0] == "Salle" ) {
					sql =   "select "+
								   "	t3.CodeEtablissement "+
								   "	,t1.CodeSalle "+
								   "	,NomSalle "+
								   " from tSalle t1 "+
								   "	inner join tEtablissement t3 "+
								   "		on t1.CodeEtablissement=t3.CodeEtablissement "+
								   "where t3.CodeEtablissement=" + args[1] + " " +
								   "order by t3.CodeEtablissement,NomSalle";
			} else {
					sql = 	"Declare " +
									"@Debut datetime " +
									"set @Debut=convert(varchar(10),'" + args[0] + "') " +
									"select " +
									"	 Salle=NomSalle " +
									"	,t3.CodeSalle" +
									"	,[Date]=convert(varchar(10),DebutSeance,103) " +
									"	,Debut=convert(varchar(5),DebutSeance,108) " +
									"	,Fin=convert(varchar(5),FinSeance,108) " +
									"	,Session=NomSession " +
									"	,Groupe=convert(varchar,CodeGroupe) " +
									"	,Matiere=isnull(ThemeSeance,NomMatiere) " +
									"	,Intervenant=NomPersonne+isnull(' '+PrenomPersonne,'') " +
									"from " +
									"	tSeance t1 " +
									"	inner join tReservation t2 " +
									"		on t1.CodeSeance=t2.CodeSeance " +
									"	inner join tSalle t3 " +
									"		on t2.CodeSalle=t3.CodeSalle " +
									"	left outer join tMatiere t4 " +
									"		on t1.CodeMatiere=t4.CodeMatiere " +
									"	left outer join tPlanifier t5 " +
									"		on t1.CodeSeance=t5.CodeSeance " +
									"	left outer join tSession t6 " +
									"		on t5.CodeSession=t6.CodeSession " +
									"	left outer join tAnimation t7 " +
									"		on t1.CodeSeance=t7.CodeSeance " +
									"	left outer join tPersonne t8 " +
									"		on t7.CodeIntervenant=t8.CodePersonne " +
									"where " +
									"	t3.CodeEtablissement=" + args[1] + " " +
									"	and convert(varchar,DebutSeance,112)=convert(varchar,@Debut,112) " +
									"order by " +
									"	Session,Groupe,Salle,DebutSeance";
			}

			SqlDataAdapter adapter = new SqlDataAdapter();
			adapter.SelectCommand = new SqlCommand(sql, connection);
			adapter.Fill(dataset);

			string filename = args[2];
			
			// Create the FileStream to write with.
			System.IO.FileStream myFileStream = new System.IO.FileStream(filename, System.IO.FileMode.Create);
			
			// Create an XmlTextWriter with the fileStream.
			System.Xml.XmlTextWriter myXmlWriter = new System.Xml.XmlTextWriter(myFileStream, System.Text.Encoding.UTF8);
			myXmlWriter.Formatting = Formatting.Indented; 

			// Write to the file with the WriteXml method.
			dataset.WriteXml(myXmlWriter);   
			myXmlWriter.Close();

			return 0;
		} catch (IndexOutOfRangeException) {
		Console.WriteLine("Invalid no of arguments");
		} catch (Exception ex) {
			Console.WriteLine("Error occured with query : " + sql + " Error : "+ ex.Message);
		}
	return 2;
	}
	
	public static bool IsInteger(string theValue)
	{
		try	{
			Convert.ToInt32(theValue);
			return true;
		} catch {
			return false;
		}
	}
}
