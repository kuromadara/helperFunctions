package com.techvariable.network.repository;

import com.techvariable.network.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

public interface UserRepository extends JpaRepository<User , Long> {

    @Query(value="select * from user where user_name = ?1" , nativeQuery = true)
    public User getUserByUserNameAll(String userName);

}
