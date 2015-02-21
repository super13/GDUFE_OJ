package pro.jdbc;
import java.sql.Connection;

import java.sql.ResultSet;


import java.sql.Statement;
public class Base {

	/**
	 * @param args
	 * @throws Exception 
	 */
	public static void main(String[] args)throws Exception {
		 for(int i=0;i<10;i++){
			 Connection conn = JdbcUtils.getConnection();
			 System.out.println(conn.getClass().getName());
			 JdbcUtils.free(null, null, conn);
		 }
	}
	
	static void template() throws Exception{
		Connection conn = null;
		Statement st = null;
		ResultSet rs = null;
		try{	
		//2.建立连接
		conn =JdbcUtils.getConnection();
		
		//3，创建语句
		st = conn.createStatement();
		
		//4。执行语句
		rs = st.executeQuery("select * from user");
		
		//5.处理结果
		while (rs.next()){
			System.out.println(rs.getObject(1)+"\t"+rs.getObject(2)+"\t"+rs.getObject(3)+"\t"+rs.getObject(4)+"\t"+rs.getObject(5)+"\t"+rs.getObject(6));
		}
		
		} finally{
			JdbcUtils.free(rs, st, conn);
		}
	}
	

}
