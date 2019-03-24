package programmer.objects;

import java.sql.ResultSet;
import java.util.ArrayList;

public abstract class Query<T> 
{
    private String m_strSql;

    public Query(String p_strSql) 
    {
        setSql(p_strSql);
    }
    
    public String getSql() 
    {
        return m_strSql;
    }

    private void setSql(String p_strSql) 
    {
        m_strSql = p_strSql;
    }

    @Override
    public String toString() 
    {
        return "Query{" + "m_strSql=" + m_strSql + '}';
    }
    
    public abstract ArrayList<T> createArrayList(ResultSet p_CResult);    
}
