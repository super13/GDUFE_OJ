package pro.jdbc.dao;

import java.io.InputStream;
import java.util.Properties;

public class DaoFactory {
	private static Object obj = null;
	private static DaoFactory instance = new DaoFactory ();
	
	private DaoFactory(){

		try {
			Properties prop = new Properties();
			InputStream inStream = DaoFactory.class.getClassLoader().
					getResourceAsStream("daoconfig.properties");
			prop.load(inStream);
			String userDaoClass = prop.getProperty("userDaoClass");
			Class<?> clazz = Class.forName(userDaoClass);
			obj = clazz.newInstance();
			inStream.close();
		} catch (Exception e) {
			throw new ExceptionInInitializerError(e);
		}
	}
	
	public static DaoFactory getInstance() {
		return instance ;
	}	
	
	public BaseDao getBaseDao(){
		return (BaseDao)obj;
	}
	
}
