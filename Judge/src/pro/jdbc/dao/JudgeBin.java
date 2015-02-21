package pro.jdbc.dao;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.LineNumberReader;
import java.util.List;


import pro.jdbc.dao.impl.DaoSpringImpl;
import pro.jdbc.domain.Statu;
import pro.jdbc.domain.User;
import pro.jdbc.domain.Problem;;

public class JudgeBin implements Runnable{
	public void copyFile(String oldPath, String newPath) {
		try {                   
			int byteread = 0;            
			File oldfile = new File(oldPath);            
			if (oldfile.exists()) { //文件存在时                
				InputStream inStream = new FileInputStream(oldPath); //读入原文件                
				@SuppressWarnings("resource")
				FileOutputStream fs = new FileOutputStream(newPath);                
				byte[] buffer = new byte[1444];                
				while ( (byteread = inStream.read(buffer)) != -1) {                                       
					fs.write(buffer, 0, byteread);                
				}                
				inStream.close();            
			}        
		}  catch (Exception e) {
			//System.out.println("复制单个文件操作出错");            
			e.printStackTrace();        
		}    
	}
    public static boolean isExist(String folder, String type) {

        File f = new File(folder);
        String[] fileList = f.list();

        for(String str:fileList) {
            File file = new File(str);
            if(file.isFile() && file.getName().startsWith(type)) {
            	return true;
            }
        }
        return false;
    }
    //mode 2为Java 1为c/c++ 判断哪个RE
	public String diffCase(String path,int ProID,int mode, long usetime, int limitedtime){
		String ans = null;
		if(usetime>limitedtime)
			return "Time Limit Exceeded!";
        Process process;
		try {
			String cmd="./diff -q "+path+"stdio/"+ProID+".out "+path + ProID+".out";
			String cmd1="./diff -q -w -B -i "+path+"stdio/"+ProID+".out "+path + ProID+".out";
			process = Runtime.getRuntime().exec(cmd);
	        InputStreamReader reader = new InputStreamReader(process.getInputStream());
	        LineNumberReader line = new LineNumberReader(reader);
	        if(line.readLine()!=null){
				process = Runtime.getRuntime().exec(cmd1);
		        InputStreamReader reader1 = new InputStreamReader(process.getInputStream());
		        LineNumberReader line1 = new LineNumberReader(reader1);
		        if(line1.readLine()==null)
		        	return "Presentation Error!";
		        if(isExist(".", "core")&&mode==1)
		        	return "Runtime Error!";
				String path1="/var/www/html/goj/Common/"; //路径
				File runerror= new File(path1 +"runerror.log");
				if(runerror.exists() && runerror.length()>0&&mode==2)
					return "Runtime Error!";
		        return "Wrong Answer!";
	                
	        }else{  	   
	        	return "Accepted!";            		   
	        }	       
		} catch (IOException e) {
			e.printStackTrace();
		}		
		return ans;		
	}
	

	@Override
	public void run() {
		while(true){
			BaseDao baseDao = new DaoSpringImpl();
			Object[] statuobj={"queuing"};
			String[] statuarg ={"result"};
			String[] userarg={"account"};//根据账号查找用户
			String[] proarg={"problem_id"};
			
			List<Statu> status = baseDao.findByProperties(statuarg,  Statu.class,statuobj);
			if(status.size()>0){
				//查找提交代码所属题目
				final List<Problem> problems=baseDao.findByProperties(proarg, Problem.class,status.get(0).getProblem_id());
				//查找提交代码的用户
				List<User> user= baseDao.findByProperties(userarg,  User.class,status.get(0).getUser());
				if(user.size()>0&&problems.size()>0){
					try{
					status.get(0).setResult("Compiling");
					baseDao.update(statuarg, status.get(0));
					
	
					//提交代码数量加1
					user.get(0).setSubmitedC(user.get(0).getSubmitedC()+1);
					
					problems.get(0).setSubmitedC(problems.get(0).getSubmitedC()+1);
					
					//拷贝文件到Main
					String path="/var/www/html/goj/Common/"; //路径
					//删除相关程序文件
					File eMain = new File(path +"Main");
					File MainCpp = new File(path +"Main.cpp");
					File MainC = new File(path +"Main.c");
					File MainJ =new File(path +"Main.java");
					File MainClass=new File(path +"Main.class");
					File errorlog= new File(path +"error.log");
					File runerror= new File(path +"runerror.log");
					MainC.delete();
					MainCpp.delete();
					eMain.delete();
					MainJ.delete();
					MainClass.delete();
					errorlog.delete();
					runerror.delete(); 
					Runtime.getRuntime().exec("./OJrmcore"); //删除RE产生的core文件
					
					int ProID=status.get(0).getProblem_id();
					switch(status.get(0).getLang()){    
						case "C++":{
							copyFile(path+"u/"+status.get(0).getUser()+"/"+ProID+".cpp"
								,path+"Main.cpp");
					        String[] compileCMD={"/bin/sh","-c","./OJg++"};
				            Process processC=Runtime.getRuntime().exec(compileCMD);
				            processC.waitFor();
				                //编译完成				          
						}break;
						case "C":{
							copyFile(path+"u/"+status.get(0).getUser()+"/"+ProID+".cpp"
									,path+"Main.c");	
					        String[] compileCMD={"/bin/sh","-c","./OJgcc"};
				            Process processC=Runtime.getRuntime().exec(compileCMD);
				            processC.waitFor();
				                //编译完成		
						}break;
						case "Java":{
							copyFile(path+"u/"+status.get(0).getUser()+"/"+ProID+".cpp"
									,path+"Main.java");	
					        String[] compileCMD={"/bin/sh","-c","./OJjavac"};
					        Process processC=Runtime.getRuntime().exec(compileCMD);
					        processC.waitFor();
						}break;	                
	
					}
					String[] statuargs ={"result","use_time"};
					switch(status.get(0).getLang()){
					case "Java":{
						if(MainClass.exists()){
							String javapath="/usr/lib/jvm/java-7-sun/bin/java ";
							String[] runCMD={"/bin/sh","-c",javapath+"Main " +
			                		"<"+path+"stdio/"+ProID+".in > " +
			                		path +ProID+".out 2>runerror.log"};								
							
		                	status.get(0).setResult("Running");
							baseDao.update(statuargs, status.get(0));
				
							//开始测试普通的输入数据
			               //开始测试判断超时的输入数据
		                
							long startTime=System.currentTimeMillis();//开始时间
			                final Process processR=Runtime.getRuntime().exec(runCMD);
			                
			                new Thread(new Runnable(){
			                @Override
			                public void run() {
			                    try {
			                        Thread.sleep(problems.get(0).getRunTimeout());
			                    } catch (InterruptedException e) {
			                    	e.printStackTrace();
			                    }
			                    processR.destroy();
			                }}).start();			               		                
			                processR.waitFor();	
			                //结束普通数据测试
			                
			      			           	
			                long endTime=System.currentTimeMillis();//结束时间
			                //结束判断超时的测试			    
				                status.get(0).setUse_time(endTime-startTime);
				                Runtime.getRuntime().exec("./OJpkill"); //防止程序出错不能正常结束
				                String s=diffCase(path,ProID,
				                		2,endTime-startTime,problems.get(0).getCalTimeout());
								status.get(0).setResult(s);
								baseDao.update(statuargs, status.get(0));		                		                
			                }else{
			                	//没有正常编译	        
								copyFile(path+"error.log"
										,path+"errorLog/"+status.get(0).getStatu_id()+".log");
			    				status.get(0).setResult("Compilation Error");
			    				baseDao.update(statuargs, status.get(0));
			                }					
						}break;
					default:{			              
		                if(eMain.exists()){
			                //运行
							String[] runCMD={"/bin/sh","-c",path+"Main " +
			                		"<"+path+"stdio/"+ProID+".in > " +
			                		path +ProID+".out 2>runerror.log"};
		                	status.get(0).setResult("Running");
							baseDao.update(statuargs, status.get(0));
							
							
							//开始测试普通的输入数据							
							long startTime=System.currentTimeMillis();//开始时间							

			                final Process processR=Runtime.getRuntime().exec(runCMD);
			                
			                new Thread(new Runnable(){
			                @Override
			                public void run() {
			                    try {
			                        Thread.sleep(problems.get(0).getRunTimeout());
			                    } catch (InterruptedException e) {
			                    	e.printStackTrace();
			                    }
			                    processR.destroy();
			                }}).start();			               		                
			                processR.waitFor();	
			                //结束普通数据测试
			                
			               
			                long endTime=System.currentTimeMillis();//结束时间
				                
				                status.get(0).setUse_time(endTime-startTime);
				                Runtime.getRuntime().exec("./OJpkill"); //防止程序出错不能正常结束
				                String s=diffCase(path,ProID,
				                		1,endTime-startTime,problems.get(0).getCalTimeout());
								status.get(0).setResult(s);
								baseDao.update(statuargs, status.get(0));		                		                
			                }else{
			                	//没有正常编译	
								copyFile(path+"error.log"
										,path+"errorLog/"+status.get(0).getStatu_id()+".log");
			    				status.get(0).setResult("Compilation Error");
			    				baseDao.update(statuargs, status.get(0));
			                }
					}
				}
					
					
	            	//如果上面的结果是ac，则用户解决题目数加1，解决题目号加上
	        		if(status.get(0).getResult()=="Accepted!"){            			
	        			if(user.get(0).getSolvedP().indexOf(String.valueOf(status.get(0).getProblem_id()))==-1){
	        				user.get(0).setSolvedC(user.get(0).getSolvedC()+1);
	        				user.get(0).setSolvedP(user.get(0).getSolvedP()+status.get(0).getProblem_id()+"|");
	        			}
	        			problems.get(0).setSolvedC(problems.get(0).getSolvedC()+1);
	        		}else{
	        			//否则没解决题目加上题目号和一个分割线| 
	        			if(user.get(0).getUnsolvedP().indexOf(String.valueOf(status.get(0).getProblem_id()))==-1)
	        				user.get(0).setUnsolvedP(user.get(0).getUnsolvedP()+status.get(0).getProblem_id()+"|");
	        		}
	        		//更新数据库中用户数据,总共4项
	        		String[] userargs={"submitedC","solvedC","solvedP","unsolvedP"};
	        		baseDao.update(userargs, user.get(0));
	        		
	        		//更新数据库中问题的数据
	        		String[] proargs={"submitedC","solvedC"};
	        		baseDao.update(proargs, problems.get(0));
		                
	                }catch(IOException | InterruptedException e){
	                	e.printStackTrace();
	                }
				}
			}
			try {
				Thread.sleep(3000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
		
	}
	
	public static void main(String[] args) {
		JudgeBin daoTest = new JudgeBin();
		new Thread(daoTest).start();
	}

}
