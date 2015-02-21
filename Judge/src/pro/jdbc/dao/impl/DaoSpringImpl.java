package pro.jdbc.dao.impl;

import java.util.List;

import org.springframework.jdbc.core.namedparam.BeanPropertySqlParameterSource;
import org.springframework.jdbc.core.namedparam.SqlParameterSource;
import org.springframework.jdbc.core.simple.ParameterizedBeanPropertyRowMapper;
import org.springframework.jdbc.core.simple.SimpleJdbcTemplate;
import org.springframework.jdbc.support.GeneratedKeyHolder;
import org.springframework.jdbc.support.KeyHolder;

import pro.jdbc.JdbcUtils;
import pro.jdbc.dao.BaseDao;

public class DaoSpringImpl implements BaseDao {
	private SimpleJdbcTemplate simple = new SimpleJdbcTemplate(JdbcUtils.getDataSource());
	@Override
	public <T> void add(String[]args, T instance) {	
		String sql="insert into goj_"+instance.getClass().getSimpleName().toLowerCase()+" (";
		for(int i=0;i<args.length;i++){		
			if(i!=args.length-1)
				sql =sql+args[i]+",";
			else
				sql =sql+args[i]+")";
		}		
		for(int i=0;i<args.length;i++){	
			if(i==0)
				sql=sql+"values(:"+args[i];
			else
				if(i!=args.length-1)
					sql=sql+",:"+args[i];
				else
					sql=sql+",:"+args[i]+")";
		}
		SqlParameterSource param = new BeanPropertySqlParameterSource(instance); 
		KeyHolder keyHolder =new GeneratedKeyHolder();
		this.simple.getNamedParameterJdbcOperations().update(sql, param, keyHolder);
	}

	@Override
	public <T> void delete( T instance) {
		String sql= "delete from goj_"+instance.getClass().getSimpleName().toLowerCase()+" where id=:id";
		SqlParameterSource param = new BeanPropertySqlParameterSource(instance); 
		KeyHolder keyHolder =new GeneratedKeyHolder();
		this.simple.getNamedParameterJdbcOperations().update(sql, param, keyHolder);
		

	}

	@Override
	public <T> List<T> findByProperties(String[]args,Class<T> clazz, Object...objs) {
		String sql="select * from goj_"+clazz.getSimpleName().toLowerCase();
		if(args != null){
			for(int i=0;i<args.length;i++){		
				if(i==0)
					sql =sql+" where "+args[i]+"=?";
				else
					sql =sql+" and "+args[i]+"=?";
			}
		}
		List<T> list=this.simple.query(sql, 
				ParameterizedBeanPropertyRowMapper.newInstance(clazz), objs);
		
		return list;
	}

	@Override
	public <T> void update(String[]args, T instance) {
		String sql="update goj_"+instance.getClass().getSimpleName().toLowerCase()+" set ";
		for(int i=0;i<args.length;i++){		
			if(i!=args.length-1)
				sql =sql+args[i]+"=:"+args[i]+",";
			else
				sql =sql+args[i]+"=:"+args[i];
		}
		sql=sql+" where "+instance.getClass().getSimpleName().toLowerCase()+
				"_id=:"+instance.getClass().getSimpleName().toLowerCase()+"_id";
		SqlParameterSource param = new BeanPropertySqlParameterSource(instance); 
		KeyHolder keyHolder =new GeneratedKeyHolder();
		this.simple.getNamedParameterJdbcOperations().update(sql, param, keyHolder);

	}

}
