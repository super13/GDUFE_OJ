package pro.jdbc;

import java.io.InputStream;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Properties;

import javax.sql.DataSource;

import org.apache.commons.dbcp.BasicDataSourceFactory;


public final class JdbcUtils {
	private static DataSource myDataSource = null;
	JdbcUtils(){
		
	}
	
	static{
		try {
			Class.forName("com.mysql.jdbc.Driver");
			Properties prop = new Properties();
			InputStream inStream = JdbcUtils.class.getClassLoader().
					getResourceAsStream("dbcpconfig.properties");
			prop.load(inStream);
			
			myDataSource =BasicDataSourceFactory.createDataSource(prop);
		} catch (Exception e) {
			throw new ExceptionInInitializerError(e);
		}

	}	
	
	public static DataSource getDataSource(){
		return myDataSource;
	}
	
	public static Connection getConnection() throws SQLException{ 
		return  myDataSource.getConnection();
	}
	
	public static void free(ResultSet rs,Statement st, Connection conn){
		try {
			if (rs!=null)
			rs.close();
			
		} catch (SQLException e) {
			e.printStackTrace();
			
		} finally{
			
			try {
			if(st!=null)
			st.close();
			
			} catch (SQLException e) {
				e.printStackTrace();
				
			} finally{
				if(conn!=null)
					try {
						conn.close();
						
					} catch (SQLException e) {
						e.printStackTrace();
					}
			}
		}
	}
}
